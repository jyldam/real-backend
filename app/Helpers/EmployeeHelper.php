<?php

namespace App\Helpers;

use App\Models\Employee;
use Illuminate\Support\Facades\Log;

class EmployeeHelper
{
    private static ?Employee $employee = null;

    public static function getEmployee(): ?Employee
    {
        if (!static::$employee && auth()->id()) {
            Log::info('[!!!] Getting employee from database');
            static::$employee = Employee::with('user')
                ->where('user_id', auth()->id())
                ->first();
        }
        Log::info('[!!!] Returning instance of employee');
        return static::$employee;
    }
}
