<?php

namespace App\Http\Controllers\V1;

use App\Models\Housing;
use Illuminate\Http\JsonResponse;
use App\Data\V1\HousingCreateData;
use App\Services\V1\HousingService;
use App\Http\Controllers\Controller;
use App\Data\V1\HousingFindManyData;
use App\Http\Resources\V1\HousingResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class HousingController extends Controller
{
    public function __construct(
        private readonly HousingService $housingService
    ) {}

    public function index(HousingFindManyData $data): AnonymousResourceCollection
    {
        $housings = $this->housingService->findMany($data);
        return HousingResource::collection($housings);
    }

    public function show(Housing $housing): JsonResponse
    {
        abort_if(!employee()->isAdmin() && $housing->employee_id !== employee()->id, 403);
        $housing->load(['region', 'employee.user', 'housingCategory']);
        return response()->json(new HousingResource($housing));
    }

    public function store(HousingCreateData $data): JsonResponse
    {
        $this->housingService->create($data);
        return response()->json('Объявление успешно создано');
    }
}
