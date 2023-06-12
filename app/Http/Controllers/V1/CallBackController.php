<?php

namespace App\Http\Controllers\V1;

use Throwable;
use App\Models\CallBack;
use Illuminate\Http\JsonResponse;
use App\Data\V1\CallBackCreateData;
use App\Data\V1\CallBackUpdateData;
use App\Services\V1\CallBackService;
use App\Http\Controllers\Controller;
use App\Data\V1\CallBackFindManyData;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CallBackController extends Controller
{
    public function __construct(
        private readonly CallBackService $callBackService,
    ) {}

    public function index(CallBackFindManyData $data): AnonymousResourceCollection
    {
        abort_if(!employee()->isAdmin() && !employee()->isRealtor(), 401);
        return $this->callBackService->findMany($data);
    }

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

    public function update(CallBackUpdateData $data, CallBack $callBack): JsonResponse
    {
        $this->callBackService->update($data, $callBack);
        return response()->json('Запрос успешно обновлен');
    }

    public function destroy(CallBack $callBack): JsonResponse
    {
        $this->callBackService->delete($callBack);
        return response()->json('Запрос успешно удален');
    }
}
