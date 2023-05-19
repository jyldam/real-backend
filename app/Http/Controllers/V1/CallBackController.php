<?php

namespace App\Http\Controllers\V1;

use Throwable;
use App\Models\CallBack;
use Illuminate\Http\JsonResponse;
use App\Data\V1\CallBackCreateData;
use App\Services\V1\CallBackService;
use App\Http\Controllers\Controller;

class CallBackController extends Controller
{
    public function __construct(
        private readonly CallBackService $callBackService
    ) {}

    /**
     * @throws Throwable
     */
    public function store(CallBackCreateData $data): JsonResponse
    {
        switch ($data->type) {
            case CallBack::TYPE_HOUSING_CALL_BACK:
                $this->callBackService->createForHousing($data);
                break;
            case CallBack::TYPE_DIDNT_GET_THROUGH_CALLBACK:
                $this->callBackService->createForAdmins($data);
                break;
            default :
                return response()->json('Необрабатываемый тип');
        };

        return response()->json('Запрос успешно создан');
    }
}
