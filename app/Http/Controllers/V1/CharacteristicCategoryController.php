<?php

namespace App\Http\Controllers\V1;

use App\Models\HousingCategory;
use App\Http\Controllers\Controller;

class CharacteristicCategoryController extends Controller
{
    public function index(HousingCategory $housingCategory)
    {
        return $housingCategory->characteristicCategories()
            ->with([
                'characteristics' => fn($query) => $query->select(['characteristic_category_id', 'name', 'label']),
            ])
            ->select(['id', 'name', 'housing_category_id'])
            ->get();
    }
}
