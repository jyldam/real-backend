<?php

namespace App\Http\Controllers\V1;

use App\Models\Housing;
use App\Services\HousingService;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\HousingResource;

class HousingController extends Controller
{
    public function __construct(
        private HousingService $housingService
    )
    {
    }

    public function index()
    {
        return HousingResource::collection(
            $this->housingService->getPublished([
                'giving_type' => request('giving_type'),
                'category_id' => request('category_id'),
            ], request('per_page'))
        );
    }

    public function show(Housing $housing)
    {
        return new HousingResource($housing->load(['region', 'employee.user', 'housingCategory']));
    }
}
