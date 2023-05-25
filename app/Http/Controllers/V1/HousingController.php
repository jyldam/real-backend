<?php

namespace App\Http\Controllers\V1;

use Throwable;
use App\Models\Housing;
use Illuminate\Http\JsonResponse;
use App\Data\V1\HousingCreateData;
use App\Data\V1\HousingUpdateData;
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
        $employee = employee();
        abort_if($employee && !$employee->isAdmin() && $housing->employee_id !== employee()->id, 403);
        abort_if(!$employee && $housing->status !== Housing::STATUS_PUBLISHED, 404);
        $housing->load(['region', 'employee.user', 'housingCategory']);
        return response()->json(new HousingResource($housing));
    }

    /**
     * @throws Throwable
     */
    public function store(HousingCreateData $data): JsonResponse
    {
        $this->housingService->create($data);
        return response()->json('Объявление успешно создано');
    }

    /**
     * @throws Throwable
     */
    public function update(HousingUpdateData $data, Housing $housing): JsonResponse
    {
        $this->housingService->update($data, $housing);
        return response()->json('Объявление успешно обновлено');
    }

    public function destroy(Housing $housing): JsonResponse
    {
        $this->housingService->delete($housing);
        return response()->json('Объявление удалено');
    }
}
