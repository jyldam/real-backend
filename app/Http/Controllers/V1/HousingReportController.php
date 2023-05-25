<?php

namespace App\Http\Controllers\V1;

use App\Models\HousingReport;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\V1\HousingReportResource;

class HousingReportController extends Controller
{
    public function index()
    {
        abort_if(!employee()->isAdmin(), 401);

        $status = request('status');

        $reports = HousingReport::query()
            ->with('housingReportType')
            ->when(
                $status,
                fn(Builder $query) => $query->where('status', $status),
                fn(Builder $query) => $query->where('status', HousingReport::STATUS_CREATED)
            )
            ->latest()
            ->paginate(request('per_page') ?: 30);

        return HousingReportResource::collection($reports);
    }
}
