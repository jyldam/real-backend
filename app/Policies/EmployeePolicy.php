<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Auth\Access\Response;

class EmployeePolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response|bool
    {
        if (+request()->input('type') === Employee::TYPE_ADMIN) {
            return Response::deny('Создание админа запрещено', 403);
        }

        return $user->employee->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Employee $employee): Response|bool
    {
        if (+request()->input('type') === Employee::TYPE_ADMIN) {
            return Response::deny('Создание админа запрещено', 403);
        }

        if ($user->employee->id === $employee->id) {
            return true;
        }

        if ($user->employee->isAdmin() && ($employee->isModerator() || $employee->isRealtor())) {
            return true;
        }

        if ($user->employee->isModerator() && $employee->isRealtor()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Employee $employee): bool
    {
        if ($user->employee->isAdmin()
            && $user->employee->id !== $employee->id
            && ($employee->isModerator() || $employee->isRealtor())) {
            return true;
        }

        return false;
    }
}
