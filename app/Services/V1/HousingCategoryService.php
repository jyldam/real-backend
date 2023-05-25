<?php

namespace App\Services\V1;

use App\Models\HousingCategory;
use App\Data\V1\HousingCategoryIndexData;
use Illuminate\Database\Eloquent\Collection;

class HousingCategoryService
{
    public function getActive(?HousingCategoryIndexData $data = null): Collection
    {
        $with = [
            'characteristicCategories.characteristics' => fn($query) => $query->orderBy('sort'),
        ];

        if ($data && $data->withHousing) {
            $with['housings'] = fn($query) => $query->published()
                ->when($data->givingType, fn($query) => $query->where('giving_type', $data->givingType))
                ->limit(3);
        }

        return HousingCategory::query()
            ->with($with)
            ->where('disabled', false)
            ->orderBy('sort')
            ->get();
    }
}
