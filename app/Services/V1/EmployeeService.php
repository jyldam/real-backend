<?php

namespace App\Services\V1;

use Throwable;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use App\Data\V1\EmployeeCreateData;
use Illuminate\Support\Facades\Log;
use App\Data\V1\EmployeeUpdateData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class EmployeeService
{
    public function __construct() {}

    /**
     * @throws Throwable
     */
    public function create(EmployeeCreateData $data): Model
    {
        $disk = Storage::disk('avatars');

        try {
            DB::beginTransaction();

            $userColumns = [
                'phone'    => $data->phone,
                'name'     => $data->name,
                'email'    => $data->email,
                'password' => Hash::make($data->password),
            ];

            $employeeColumns = [
                'type' => $data->type,
            ];

            if ($data->avatar) {
                $fileName = $disk->putFile('', $data->avatar);
                abort_if($fileName === false, 400, 'Не удалось загрузить аватар');
                $employeeColumns['avatar_url'] = "/storage/avatars/{$fileName}";
            }

            $employee = User::query()
                ->create($userColumns)
                ->employee()->create($employeeColumns);

            DB::commit();

            return $employee;
        } catch (QueryException $exception) {
            if ($data->avatar) {
                $disk->delete($data->avatar->hashName());
            }
            DB::rollBack();
            Log::error($exception->getMessage());
            throw $exception;
        }
    }

    /**
     * @throws Throwable
     */
    public function update(EmployeeUpdateData $data, Employee $employee): void
    {
        $disk = Storage::disk('avatars');

        try {
            DB::beginTransaction();

            $authenticatedEmployee = employee();

            $userColumns = [
                'phone' => $data->phone,
                'name'  => $data->name,
                'email' => $data->email,
            ];
            $employeeColumns = [];

            if ($data->type) {
                $employeeColumns['type'] =
                    $authenticatedEmployee->id !== $employee->id && $authenticatedEmployee->isAdmin()
                        ? $data->type
                        : $employee->type;
            }

            if ($data->password) {
                $userColumns['password'] = Hash::make($data->password);
                $userColumns['password_last_updated_at'] = now();
            }

            if ($data->avatar) {
                if ($employee->avatar_file) {
                    $fileName = $disk->putFileAs('', $data->avatar, $employee->avatar_file);
                } else {
                    $fileName = $disk->putFile('', $data->avatar);
                    $employeeColumns['avatar_url'] = "/storage/avatars/{$fileName}";
                }
                abort_if($fileName === false, 400, 'Не удалось загрузить аватар');
            }

            $employee->update($employeeColumns);
            $employee->user()->update($userColumns);

            DB::commit();
        } catch (QueryException $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            throw $exception;
        }
    }

    public function delete(Employee $employee): void
    {
        $employee->delete();
        $employee->user()->delete();
        Storage::disk('avatars')->delete($employee->avatar_file);
    }
}
