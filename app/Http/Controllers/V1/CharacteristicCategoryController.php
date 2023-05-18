<?php

namespace App\Http\Controllers\V1;

use App\Models\HousingCategory;
use App\Http\Controllers\Controller;
use App\Services\V1\CharacteristicCategoryService;
use App\Http\Resources\V1\CharacteristicCategoryResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CharacteristicCategoryController extends Controller
{
    public function __construct(
        private readonly CharacteristicCategoryService $characteristicCategoryService
    ) {}

    public function index(HousingCategory $housingCategory): AnonymousResourceCollection
    {
        $categories = $this->characteristicCategoryService->getByHousingCategory($housingCategory);
        return CharacteristicCategoryResource::collection($categories);
    }
}
