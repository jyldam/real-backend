<?php

namespace App\Http\Controllers\V1;

use App\Models\HousingCategory;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\V1\HousingCategoryRequest;

class HousingCategoryController extends Controller
{
    public function indexGuest(): JsonResponse
    {
        $categories = HousingCategory::query()
            ->select(['id', 'name'])
            ->where('disabled', false)
            ->orderBy('sort')
            ->get();
        return response()->json($categories);
    }

    public function indexAuthenticated(): JsonResponse
    {
        $categories = HousingCategory::query()->orderBy('sort')->get();
        return response()->json($categories);
    }

    public function create(HousingCategoryRequest $request): JsonResponse
    {
        $category = HousingCategory::query()->create($request->validated());
        return response()->json($category);
    }

    public function update(HousingCategoryRequest $request, HousingCategory $category): JsonResponse
    {
        $category->update($request->validated());
        return response()->json($category);
    }

    public function destroy(HousingCategory $category): JsonResponse
    {
        $category->delete();
        return response()->json($category);
    }
}
