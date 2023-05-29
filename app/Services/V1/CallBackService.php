<?php

namespace App\Services\V1;

use Throwable;
use App\Models\CallBack;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use App\Data\V1\CallBackCreateData;
use Illuminate\Support\Facades\Log;
use App\Data\V1\CallBackUpdateData;
use App\Data\V1\CallBackFindManyData;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\V1\CallBackResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CallBackService
{
    public function findMany(CallBackFindManyData $data): AnonymousResourceCollection
    {
        $callBacks = CallBack::query()
            ->with('employee')
            ->when(
                $data->status,
                fn(Builder $query) => $query->where('status', $data->status),
                fn(Builder $query) => $query->where('status', CallBack::STATUS_CREATED),
            )
            ->when(
                employee()->isRealtor(),
                fn(Builder $query) => $query->where('employee_id', employee()->id),
            )
            ->latest()
            ->paginate($data->perPage ?: 30);

        return CallBackResource::collection($callBacks);
    }

    /**
     * @throws Throwable
     */
    public function createForHousing(CallBackCreateData $data): void
    {
        try {
            DB::beginTransaction();

            $extra = $data->housingId ? ['housing_id' => $data->housingId] : [];

            CallBack::query()->create([
                'employee_id' => $data->employeeId,
                'phone'       => $data->phone,
                'type'        => $data->type,
                'extra'       => $extra,
                'status'      => CallBack::STATUS_CREATED,
            ]);

            DB::commit();
        } catch
        (QueryException $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            abort(400, 'Не удалось создать запрос');
        }
    }

    /**
     * @throws Throwable
     */
    public function createForAdmins(CallBackCreateData $data): void
    {
        try {
            DB::beginTransaction();

            $admins = Employee::query()->admins()->get();
            $extra = $data->housingId ? ['housing_id' => $data->housingId] : [];

            foreach ($admins as $admin) {
                CallBack::query()->create([
                    'employee_id' => $admin->id,
                    'phone'       => $data->phone,
                    'type'        => $data->type,
                    'extra'       => $extra,
                    'status'      => CallBack::STATUS_CREATED,
                ]);
            }

            DB::commit();
        } catch (QueryException $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            abort(400, 'Не удалось создать запрос');
        }
    }

    public function update(CallBackUpdateData $data, CallBack $callBack): void
    {
        $callBack->update([
            'status' => $data->status,
        ]);
    }

    public function delete(CallBack $callBack): void
    {
        $callBack->delete();
    }
}
