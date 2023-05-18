<?php

namespace App\Services\V1;

use App\Models\Housing;
use Illuminate\Support\Facades\DB;
use App\Data\V1\HousingCreateData;
use Illuminate\Support\Facades\Log;
use App\Data\V1\HousingFindManyData;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class HousingService
{
    public function findMany(HousingFindManyData $data): LengthAwarePaginator
    {
        $employee = auth()->user()?->employee;
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
                    foreach ($data->characteristics as $key => $value) {
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
            ->paginate($data->perPage ?? 30);
    }

    public function create(HousingCreateData $data): void
    {
        $disk = Storage::disk('housing_assets');

        try {
            DB::beginTransaction();

            // Create housing
            $housing = Housing::query()->create([
                'employee_id'         => auth()->user()->employee->id,
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
                    'value' => $characteristic->value,
                ]);
            }

            // Upload assets
            foreach ($data->assets as $asset) {
                $fileName = $disk->putFile('', $asset->file);
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
}
