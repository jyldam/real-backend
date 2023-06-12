<?php

namespace App\Http\Controllers\V1;

use App\Models\GivingType;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class GivingTypeController extends Controller
{
    public function index(): JsonResponse
    {
        $givingTypes = GivingType::query()
            ->select(['id', 'name', 'slug'])
            ->get();
        return response()->json($givingTypes);
    }
}
