<?php

use App\Models\Employee;

if (!function_exists('employee')) {
    function employee()
    {
        $userId = auth()->id();
        if (!$userId) {
            return null;
        }
        return Employee::with('user')
            ->where('user_id', $userId)
            ->first();
    }
}

if (!function_exists('checkPolicy')) {
    function checkPolicy($model, $ability, $arguments = [])
    {
        $user = auth()->user();
        abort_if($user && !$user->can($ability, [$model, ...$arguments]), 403);
    }
}

if (!function_exists('maskPhone')) {
    function maskPhone($phone)
    {
        return '+7 (' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3) . '-' . substr($phone, 6, 2) . '-' . substr($phone, 8, 2);
    }
}
