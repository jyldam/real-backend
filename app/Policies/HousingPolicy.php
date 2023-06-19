<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Housing;

class HousingPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Housing $housing): bool
    {
        if ($user?->employee) {
            return $user->employee->isAdmin()
                || $user->employee->isModerator()
                || $user->employee->id === $housing->employee_id;
        }

        return !$user?->employee && $housing->status === Housing::STATUS_PUBLISHED;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->employee;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Housing $housing): bool
    {
        return $user->employee
            && (
                $user->employee->isAdmin()
                || $user->employee->isModerator()
                || ($housing->status === Housing::STATUS_ON_MODERATION && $user->employee->id === $housing->employee_id)
            );
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Housing $housing): bool
    {
        return $user->employee
            && (
                $user->employee->isAdmin()
                || $user->employee->isModerator()
                || ($housing->status === Housing::STATUS_ON_MODERATION && $user->employee->id === $housing->employee_id)
            );
    }
}
