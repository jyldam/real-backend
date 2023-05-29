<?php

use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

if (!function_exists('employee')) {
    function employee(): ?Employee
    {
        return Auth::user()?->employee;
    }
}

if (!function_exists('maskPhone')) {
    function maskPhone($phone)
    {
        return '+7 (' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3) . '-' . substr($phone, 6, 2) . '-' . substr($phone, 8, 2);
    }
}
