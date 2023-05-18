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

class EmployeeService
{
    public function __construct() {}

    /**
     * @throws Throwable
     */
    public function create(EmployeeCreateData $data): void
    {
        $disk = Storage::disk('avatars');

        try {
            DB::beginTransaction();

            $fileName = $disk->putFile('', $data->avatar);
            abort_if($fileName === false, 400, 'Не удалось загрузить аватар');

            User::query()
                ->create([
                    'phone'    => $data->phone,
                    'name'     => $data->name,
                    'email'    => $data->email,
                    'password' => Hash::make($data->password),
                ])
                ->employee()->create([
                    'avatar_url' => "/storage/avatars/{$fileName}",
                    'type'       => $data->type,
                ]);

            DB::commit();
        } catch (QueryException $exception) {
            $disk->delete($data->avatar->hashName());
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

            $columns = [
                'phone' => $data->phone,
                'name'  => $data->name,
                'email' => $data->email,
            ];

            if ($data->password) {
                $columns['password'] = Hash::make($data->password);
            }

            $authenticatedEmployee = Auth::user()->employee;

            $employee->update([
                'type' => $authenticatedEmployee->id !== $employee->id && $authenticatedEmployee->isAdmin()
                    ? $data->type
                    : $employee->type,
            ]);
            $employee->user()->update($columns);

            if ($data->avatar) {
                $fileName = $disk->putFileAs('', $data->avatar, $employee->avatar_file);
                abort_if($fileName === false, 400, 'Не удалось загрузить аватар');
            }

            DB::commit();
        } catch (QueryException $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            throw $exception;
        }
    }
}
