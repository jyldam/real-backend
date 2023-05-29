<?php

namespace App\Http\Controllers\V1;

use App\Models\HousingReport;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Data\V1\HousingReportCreateData;
use App\Data\V1\HousingReportUpdateData;
use Illuminate\Database\Eloquent\Builder;
use App\Services\V1\HousingReportService;
use App\Http\Resources\V1\HousingReportResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class HousingReportController extends Controller
{
    public function __construct(
        private readonly HousingReportService $housingReportService,
    ) {}

    public function index(): AnonymousResourceCollection
    {
        abort_unless(employee()->isAdmin(), 401);

        $status = request('status');

        $reports = HousingReport::query()
            ->with('housingReportType')
            ->when(
                $status,
                fn(Builder $query) => $query->where('status', $status),
                fn(Builder $query) => $query->where('status', HousingReport::STATUS_CREATED),
            )
            ->latest()
            ->paginate(request('per_page') ?: 30);

        return HousingReportResource::collection($reports);
    }

    public function store(HousingReportCreateData $data): JsonResponse
    {
        abort_unless($this->housingReportService->ipAddressHasAccess(), 423);
        $this->housingReportService->create($data);
        return response()->json('Жалоба успешно отправлена');
    }

    public function update(HousingReportUpdateData $data, HousingReport $housingReport): JsonResponse
    {
        abort_unless(employee()->isAdmin() || employee()->isModerator(), 401);
        $this->housingReportService->update($data, $housingReport);
        return response()->json('Жалоба успешно обновлена');
    }

    public function destroy(HousingReport $housingReport): JsonResponse
    {
        abort_unless(employee()->isAdmin() || employee()->isModerator(), 401);
        $this->housingReportService->delete($housingReport);
        return response()->json('Жалоба успешно удалена');
    }
}
