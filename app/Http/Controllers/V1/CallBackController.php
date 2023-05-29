<?php

namespace App\Http\Controllers\V1;

use Throwable;
use App\Models\CallBack;
use Illuminate\Http\JsonResponse;
use App\Data\V1\CallBackCreateData;
use App\Services\V1\CallBackService;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\V1\CallBackResource;

class CallBackController extends Controller
{
    public function __construct(
        private readonly CallBackService $callBackService
    ) {}

    public function index()
    {
        abort_if(!employee()->isAdmin() && !employee()->isRealtor(), 401);

        $status = request('status');

        $callBacks = CallBack::query()
            ->with('employee')
            ->when(
                $status,
                fn(Builder $query) => $query->where('status', $status),
                fn(Builder $query) => $query->where('status', CallBack::STATUS_CREATED)
            )
            ->when(
                employee()->isRealtor(),
                fn(Builder $query) => $query->where('employee_id', employee()->id)
            )
            ->latest()
            ->paginate(request('per_page') ?: 30);

        return CallBackResource::collection($callBacks);
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
}
