<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\CharacteristicCategory;

class CharacteristicController extends Controller
{
    public function index(CharacteristicCategory $category): JsonResponse
    {
        $characteristics = $category->characteristics()
            ->select(['characteristic_category_id', 'name', 'label'])
            ->get();
        return response()->json($characteristics);
    }
}
