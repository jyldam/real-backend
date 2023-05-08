<?php

namespace App\Services;

use App\Models\HousingCategory;

class CharacteristicCategoryService
{
    public function getByHousingCategory(HousingCategory $housingCategory)
    {
        return $housingCategory->characteristicCategories()
            ->with(['children.characteristics', 'characteristics',])
            ->whereNull('parent_id')
            ->get();
    }
}
