<?php

use App\Helpers\EmployeeHelper;
use App\Models\Employee;

if (!function_exists('employee')) {
    function employee(): ?Employee
    {
        return EmployeeHelper::getEmployee();
    }
}

if (!function_exists('maskPhone')) {
    function maskPhone($phone)
    {
        return '+7 (' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3) . '-' . substr($phone, 6, 2) . '-' . substr($phone, 8, 2);
    }
}
