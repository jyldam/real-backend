<?php

namespace App\Http\Controllers\V1;

use App\Models\HousingCategory;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\V1\HousingCategoryService;
use App\Http\Resources\V1\HousingCategoryResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class HousingCategoryController extends Controller
{
    public function __construct(
        private readonly HousingCategoryService $housingCategoryService
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return HousingCategoryResource::collection($this->housingCategoryService->getActive());
    }

    public function show(HousingCategory $category): JsonResponse
    {
        if ($category->disabled) {
            abort(404);
        }

        $category
            ->load(['characteristicCategories.characteristics' => fn($query) => $query->orderBy('sort')])
            ->makeHidden([
                'disabled',
                'created_at',
                'updated_at',
                'sort',
            ]);

        return response()->json(new HousingCategoryResource($category));
    }
}
