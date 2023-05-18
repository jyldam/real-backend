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
