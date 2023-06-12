<?php

namespace App\Http\Controllers\V1;

use Throwable;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use App\Data\V1\EmployeeCreateData;
use App\Data\V1\EmployeeUpdateData;
use App\Services\V1\EmployeeService;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\EmployeeResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EmployeeController extends Controller
{
    public function __construct(
        private readonly EmployeeService $employeeService,
    ) {}

    public function index(): AnonymousResourceCollection
    {
        $employees = Employee::query()
            ->with('user')
            ->latest()
            ->paginate(request('per_page') ?: 30);
        return EmployeeResource::collection($employees);
    }

    public function show(Employee $employee): JsonResponse
    {
        $employee->load('user');
        return response()->json(new EmployeeResource($employee));
    }

    /**
     * @throws Throwable
     */
    public function store(EmployeeCreateData $data): JsonResponse
    {
        abort_if($data->type === Employee::TYPE_ADMIN, 403, 'Создание админа запрещено');
        abort_if(
            !employee()->isAdmin() && !employee()->isModerator(),
            403,
        );
        $this->employeeService->create($data);
        return response()->json('Сотрудник успешно создан');
    }

    /**
     * @throws Throwable
     */
    public function update(EmployeeUpdateData $data, Employee $employee): JsonResponse
    {
        abort_if(
            $data->type === Employee::TYPE_ADMIN,
            403,
            'Создание админа запрещено',
        );
        abort_if(
            $employee->id !== employee()->id && !employee()->isAdmin() && !employee()->isModerator(),
            403,
        );
        $this->employeeService->update($data, $employee);
        return response()->json('Сотрудник успешно обновлен');
    }

    public function destroy(Employee $employee): JsonResponse
    {
        $authenticatedEmployee = employee();
        abort_if(
            $authenticatedEmployee->id === $employee->id
            || !$authenticatedEmployee->isAdmin()
            || $employee->isAdmin(),
            403,
        );

        $this->employeeService->delete($employee);
        return response()->json('Сотрудник успешно удален');
    }
}
