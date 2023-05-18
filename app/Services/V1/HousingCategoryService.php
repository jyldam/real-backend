<?php

namespace App\Services\V1;

use App\Models\HousingCategory;
use Illuminate\Database\Eloquent\Collection;

class HousingCategoryService
{
    public function getActive(): Collection
    {
        return HousingCategory::query()
            ->with(['characteristicCategories.characteristics' => fn($query) => $query->orderBy('sort')])
            ->where('disabled', false)
            ->orderBy('sort')
            ->get();
    }
}
