<?php

namespace App\Services\V1;

use Throwable;
use App\Models\CallBack;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use App\Data\V1\CallBackCreateData;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class CallBackService
{
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
            ]);

            DB::commit();
        } catch
        (QueryException $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            abort(400, 'Не удалость создать запрос');
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
                ]);
            }

            DB::commit();
        } catch (QueryException $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            abort(400, 'Не удалость создать запрос');
        }
    }
}
