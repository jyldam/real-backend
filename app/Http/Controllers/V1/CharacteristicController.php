<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\CharacteristicCategory;

class CharacteristicController extends Controller
{
    public function index(CharacteristicCategory $category)
    {
        return $category->characteristics()
            ->select(['characteristic_category_id', 'name', 'label'])
            ->get();
    }
}
