<?php

namespace App\Http\Controllers\V1;

use App\Models\HousingFilter;
use App\Models\HousingCategory;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class HousingFilterController extends Controller
{
    public function index(HousingCategory $category): JsonResponse
    {
        $filters = HousingFilter::query()
            ->where('housing_category_id', $category->id)
            ->get();
        return response()->json($filters);
    }
}
