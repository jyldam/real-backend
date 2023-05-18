<?php

namespace App\Services\V1;

use App\Models\HousingCategory;
use Illuminate\Database\Eloquent\Collection;

class CharacteristicCategoryService
{
    public function getByHousingCategory(HousingCategory $housingCategory): Collection
    {
        return $housingCategory->characteristicCategories()
            ->with(['children.characteristics', 'characteristics',])
            ->whereNull('parent_id')
            ->get();
    }
}
