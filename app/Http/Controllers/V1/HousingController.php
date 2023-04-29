<?php

namespace App\Http\Controllers\V1;

use App\Models\Housing;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\HousingResource;

class HousingController extends Controller
{
    public function index()
    {
        $givingType = request('giving_type');
        $status = request('status');
        $perPage = request('per_page');

        $housings = Housing::query()
            ->with([
                'region'          => fn($query) => $query->select(['id', 'name']),
                'employee'        => fn($query) => $query->with([
                    'user' => fn($query) => $query->select(['id', 'phone', 'name']),
                ])->select(['id', 'user_id']),
                'housingCategory' => fn($query) => $query->select(['id', 'name']),
            ])
            ->select(['id', 'price', 'address', 'region_id', 'employee_id', 'housing_category_id'])
            ->where('status', Housing::STATUS_PUBLISHED)
            ->where('giving_type', $givingType)
            ->when($status, fn($query) => $query->where('status', $status))
            ->paginate($perPage ?: 30);

        return HousingResource::collection($housings);
    }

    public function show(Housing $housing)
    {
        return new HousingResource($housing->load([
            'region'          => fn($query) => $query->select(['id', 'name']),
            'employee'        => fn($query) => $query->with([
                'user' => fn($query) => $query->select(['id', 'phone', 'name']),
            ])->select(['id', 'user_id']),
            'housingCategory' => fn($query) => $query->select(['id', 'name']),
        ]));
    }
}
