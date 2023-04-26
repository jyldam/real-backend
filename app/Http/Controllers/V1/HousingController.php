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
        $housings = Housing::query()
            ->with([
                'region'   => fn($query) => $query->select(['id', 'name']),
                'employee' => fn($query) => $query->with([
                    'user' => fn($query) => $query->select(['id', 'phone', 'name']),
                ])->select(['id', 'user_id']),
            ])
            ->select(['id', 'price', 'address', 'region_id', 'employee_id'])
            ->where('status', Housing::STATUS_PUBLISHED)
            ->where('giving_type', $givingType)
            ->paginate(30);

        return HousingResource::collection($housings);
    }
}
