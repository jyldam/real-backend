<?php

namespace App\Http\Controllers\V1;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class RegionController extends Controller
{
    public function index(): JsonResponse
    {
        $regions = Region::with('recursiveChildren')
            ->whereNull('parent_id')
            ->get();
        return response()->json($regions);
    }
}
