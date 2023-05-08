<?php

namespace App\Services;

use App\Models\HousingCategory;

class HousingCategoryService
{
    public function getActive()
    {
        return HousingCategory::query()
            ->with(['characteristicCategories.characteristics' => fn($query) => $query->orderBy('sort')])
            ->where('disabled', false)
            ->orderBy('sort')
            ->get();
    }
}
