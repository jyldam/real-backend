<?php

namespace App\Http\Controllers\V1;

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
        private readonly EmployeeService $employeeService
    ) {}

    public function index(): AnonymousResourceCollection
    {
        $employees = Employee::query()->with('user')->get();
        return EmployeeResource::collection($employees);
    }

    public function store(EmployeeCreateData $data): JsonResponse
    {
        $this->employeeService->create($data);
        return response()->json('Сотрудник успешно создан');
    }

    public function update(EmployeeUpdateData $data, Employee $employee): JsonResponse
    {
        $this->employeeService->update($data, $employee);
        return response()->json('Сотрудник успешно обновлен');
    }
}
