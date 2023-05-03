<?php

namespace App\Http\Controllers\V1;

use App\Models\HousingCategory;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\HousingCategoryRequest;
use App\Http\Resources\V1\HousingCategoryResource;

class HousingCategoryController extends Controller
{
    public function indexGuest()
    {
        $categories = HousingCategory::query()
            ->with([
                'characteristicCategories' => fn($query) => $query->with([
                    'characteristics' => fn($query) => $query->select([
                        'id',
                        'characteristic_category_id',
                        'name',
                        'label',
                        'sort',
                    ])->orderBy('sort'),
                ])->select(['id', 'housing_category_id']),
            ])
            ->select(['id', 'name', 'mesh_name'])
            ->where('disabled', false)
            ->orderBy('sort')
            ->get();

        return HousingCategoryResource::collection($categories);
    }

    public function indexAuthenticated(): JsonResponse
    {
        $categories = HousingCategory::query()->orderBy('sort')->get();
        return response()->json($categories);
    }

    public function show(HousingCategory $category)
    {
        if ($category->disabled) {
            abort(404);
        }

        return new HousingCategoryResource(
            $category
                ->load([
                    'characteristicCategories' => fn($query) => $query->with([
                        'characteristics' => fn($query) => $query->select([
                            'id',
                            'characteristic_category_id',
                            'name',
                            'label',
                            'sort',
                        ])->orderBy('sort'),
                    ])->select(['id', 'housing_category_id']),
                ])
                ->makeHidden([
                    'disabled',
                    'created_at',
                    'updated_at',
                    'sort',
                ])
        );
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
