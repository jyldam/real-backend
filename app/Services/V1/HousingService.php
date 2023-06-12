<?php

namespace App\Services\V1;

use Throwable;
use App\Models\Housing;
use App\Data\V1\HousingCreateData;
use App\Data\V1\HousingUpdateData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Data\V1\HousingFindManyData;
use App\Models\CharacteristicCategory;
use Spatie\LaravelData\DataCollection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class HousingService
{
    public function findMany(HousingFindManyData $data): LengthAwarePaginator
    {
        $status = employee() && $data->status
            ? $data->status
            : Housing::STATUS_PUBLISHED;

        return Housing::query()
            ->with([
                'region',
                'employee.user',
                'givingTypeSlug',
                'housingAssets',
                'housingCategory',
                'characteristics' => fn(BelongsToMany $query) => $query->with('characteristicCategory')
                    ->orderBy('sort'),
            ])
            ->where('status', $status)
            ->when(
                $status !== Housing::STATUS_PUBLISHED && employee()?->isRealtor(),
                fn(Builder $query) => $query->where('employee_id', employee()->id),
            )
            ->when(
                $data->givingType,
                fn(Builder $query) => $query->where('giving_type', $data->givingType),
            )
            ->when(
                $data->housingCategoryId,
                fn(Builder $query) => $query->where(
                    'housing_category_id',
                    $data->housingCategoryId,
                ),
            )
            ->when(
                $data->characteristics,
                fn(Builder $query) => $query->whereHas('characteristics', function (Builder $query) use ($data) {
                    foreach ($data->characteristics as $key => $value) {
                        if (!$value) {
                            continue;
                        }

                        $query->where('name', $key);

                        if (!is_array($value)) {
                            $value = explode(',', $value);
                            $query->whereJsonContains('value', $value);
                            for ($i = 1 ; $i < count($value) - 1 ; $i++) {
                                $query->orWhereJsonContains('value', $value[$i]);
                            }
                            return;
                        }

                        if (count($value) < 1) {
                            return;
                        }

                        $query->whereRaw("(value #>> '{}')::int >= ? and (value #>> '{}')::int <= ?", [
                            $value[0],
                            $value[1],
                        ]);
                    }
                }),
            )
            ->when(
                $data->employeeId,
                fn(Builder $query) => $query->where('employee_id', $data->employeeId),
            )
            ->when(
                $data->address,
                fn(Builder $query) => $query->where('address', 'ilike', "%{$data->address}%"),
            )
            ->when(
                $data->price,
                fn(Builder $query) => count($data->price) === 1
                    ? $query->where('price', '>=', $data->price[0])
                    : $query->whereBetween('price', $data->price),
            )
            ->latest()
            ->paginate($data->perPage ?? 30);
    }

    /**
     * @throws Throwable
     */
    public function create(HousingCreateData $data): void
    {
        $this->validateCharacteristics($data->housingCategoryId, $data->characteristics);

        $disk = Storage::disk('housing_assets');

        try {
            DB::beginTransaction();

            // Create housing
            $housing = Housing::query()->create([
                'employee_id'         => employee()?->id ?? $data->employeeId,
                'status'              => $data->moderate ? Housing::STATUS_ON_MODERATION : Housing::STATUS_CREATED,
                'housing_category_id' => $data->housingCategoryId,
                'price'               => $data->price,
                'region_id'           => $data->regionId,
                'address'             => $data->address,
                'giving_type'         => $data->givingType,
                'owner_name'          => $data->ownerName,
                'owner_phone'         => $data->ownerPhone,
                'contract_number'     => $data->contractNumber,
            ]);

            // Upload assets
            foreach ($data->assets as $asset) {
                $fileName = $disk->putFile($housing->id, $asset->file);
                abort_if($fileName === false, 400, 'Не удалось загрузить одно из изображений');
                $housing->housingAssets()->create([
                    'url'  => "/storage/housing_assets/{$fileName}",
                    'type' => $asset->type,
                ]);
            }

            // Create characteristics
            if ($data->characteristics !== null) {
                foreach ($data->characteristics as $characteristic) {
                    $housing->characteristics()->attach($characteristic->characteristicId, [
                        'value' => json_encode($characteristic->value),
                    ]);
                }
            }

            DB::commit();
        } catch (QueryException $exception) {
            foreach ($data->assets as $asset) {
                $disk->delete($asset->file->hashName());
            }
            DB::rollBack();
            Log::error($exception->getMessage());
            throw $exception;
        }
    }

    /**
     * @throws Throwable
     */
    public function update(HousingUpdateData $data, Housing $housing): void
    {
        $disk = Storage::disk('housing_assets');

        try {
            DB::beginTransaction();

            // Create housing
            $housing->update([
                'status'              => employee()->isRealtor() ? $housing->status : $data->status,
                'housing_category_id' => $data->housingCategoryId,
                'price'               => $data->price,
                'region_id'           => $data->regionId,
                'address'             => $data->address,
                'giving_type'         => $data->givingType,
            ]);

            // Create characteristics
            if ($data->characteristics !== null) {
                $housing->characteristics()->detach();

                foreach ($data->characteristics as $characteristic) {
                    $housing->characteristics()->attach($characteristic->characteristicId, [
                        'value' => json_encode($characteristic->value),
                    ]);
                }
            }

            // Upload assets
            if ($data->assets !== null) {
                $disk->deleteDirectory($housing->id);
                $housing->housingAssets()->delete();

                foreach ($data->assets as $asset) {
                    $fileName = $disk->putFile($housing->id, $asset->file);
                    abort_if($fileName === false, 400, 'Не удалось загрузить одно из изображений');
                    $housing->housingAssets()->create([
                        'url'  => "/storage/housing_assets/{$fileName}",
                        'type' => $asset->type,
                    ]);
                }
            }

            DB::commit();
        } catch (QueryException $exception) {
            if ($data->assets !== null) {
                foreach ($data->assets as $asset) {
                    $disk->delete($asset->file->hashName());
                }
            }
            DB::rollBack();
            Log::error($exception->getMessage());
            throw $exception;
        }
    }

    public function delete(Housing $housing): void
    {
        $housing->delete();
        Storage::disk('housing_assets')->deleteDirectory($housing->id);
    }

    /**
     * @throws ValidationException
     */
    private function validateCharacteristics(int $housingCategoryId, ?DataCollection $characteristics): void
    {
        $characteristicCategories = CharacteristicCategory::query()
            ->with('characteristics')
            ->where('housing_category_id', $housingCategoryId)
            ->get();

        $rules = [];
        $attributes = [];

        foreach ($characteristicCategories as $characteristicCategory) {
            foreach ($characteristicCategory->characteristics as $characteristic) {
                if ($characteristic->required) {
                    $rules["characteristics.id_{$characteristic->id}"] = ['required'];
                    $attributes["characteristics.id_{$characteristic->id}"] = mb_strtolower($characteristic->label);
                }
            }
        }

        $data = [
            'characteristics' => [],
        ];

        if ($characteristics) {
            foreach ($characteristics as $characteristic) {
                $data['characteristics']["id_{$characteristic->characteristicId}"] = $characteristic->value;
            }
        }

        $validator = Validator::make(
            data: $data,
            rules: $rules,
            attributes: $attributes,
        );

        $validator->validate();
    }
}
