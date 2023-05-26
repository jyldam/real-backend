<?php

namespace App\Services\V1;

use Throwable;
use App\Models\Housing;
use Illuminate\Support\Facades\DB;
use App\Data\V1\HousingCreateData;
use App\Data\V1\HousingUpdateData;
use Illuminate\Support\Facades\Log;
use App\Data\V1\HousingFindManyData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class HousingService
{
    public function findMany(HousingFindManyData $data): LengthAwarePaginator
    {
        $employee = Auth::user()?->employee;
        $status = $employee && $data->status
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
                $status !== Housing::STATUS_PUBLISHED && $employee?->isRealtor(),
                fn(Builder $query) => $query->where('employee_id', $employee->id)
            )
            ->when(
                $data->givingType,
                fn(Builder $query) => $query->where('giving_type', $data->givingType)
            )
            ->when(
                $data->housingCategoryId,
                fn(Builder $query) => $query->where(
                    'housing_category_id',
                    $data->housingCategoryId
                )
            )
            ->when(
                $data->characteristics,
                fn(Builder $query) => $query->whereHas('characteristics', function (Builder $query) use ($data) {
                    foreach (array_filter($data->characteristics) as $key => $value) {
                        $query->where('name', $key);

                        if (!is_array($value)) {
                            $query->whereJsonContains('value', $value);
                            return;
                        }

                        if (count($value) < 1) {
                            return;
                        }

                        $query->whereJsonContains('value', $value[0]);
                        foreach ($value as $v) {
                            $query->orWhereJsonContains('value', $v);
                        }
                    }
                })
            )
            ->when(
                $data->employeeId,
                fn(Builder $query) => $query->where('employee_id', $data->employeeId)
            )
            ->latest()
            ->paginate($data->perPage ?? 30);
    }

    /**
     * @throws Throwable
     */
    public function create(HousingCreateData $data): void
    {
        $disk = Storage::disk('housing_assets');

        try {
            DB::beginTransaction();

            // Create housing
            $housing = Housing::query()->create([
                'employee_id'         => Auth::user()->employee->id,
                'status'              => $data->moderate ? Housing::STATUS_ON_MODERATION : Housing::STATUS_CREATED,
                'housing_category_id' => $data->housingCategoryId,
                'price'               => $data->price,
                'region_id'           => $data->regionId,
                'address'             => $data->address,
                'giving_type'         => $data->givingType,
            ]);

            // Create characteristics
            foreach ($data->characteristics as $characteristic) {
                $housing->characteristics()->attach($characteristic->characteristicId, [
                    'value' => json_encode($characteristic->value),
                ]);
            }

            // Upload assets
            foreach ($data->assets as $asset) {
                $fileName = $disk->putFile($housing->id, $asset->file);
                abort_if($fileName === false, 400, 'Не удалось загрузить одно из изображений');
                $housing->housingAssets()->create([
                    'url'  => "/storage/housing_assets/{$fileName}",
                    'type' => $asset->type,
                ]);
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
}
