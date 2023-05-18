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
        return response()->json();
    }

    public function store(Request $request): JsonResponse
    {
        return response()->json('Регион успешно создан');
    }

    public function show(Region $region): JsonResponse
    {
        return response()->json();
    }

    public function update(Request $request, Region $region): JsonResponse
    {
        return response()->json('Регион успешно обновлен');
    }

    public function destroy(Region $region): JsonResponse
    {
        return response()->json();
    }
}
