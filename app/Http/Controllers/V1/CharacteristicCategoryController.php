<?php

namespace App\Http\Controllers\V1;

use App\Models\HousingCategory;
use App\Http\Controllers\Controller;
use App\Services\CharacteristicCategoryService;
use App\Http\Resources\V1\CharacteristicCategoryResource;

class CharacteristicCategoryController extends Controller
{
    public function __construct(
        private CharacteristicCategoryService $characteristicCategoryService
    )
    {
    }

    public function index(HousingCategory $housingCategory)
    {
        return CharacteristicCategoryResource::collection(
            $this->characteristicCategoryService->getByHousingCategory($housingCategory)
        );
    }
}
