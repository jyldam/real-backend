<?php

use App\Models\User;
use App\Models\Employee;
use App\Data\V1\EmployeeCreateData;
use App\Services\V1\EmployeeService;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        (new EmployeeService())->create(new EmployeeCreateData(
            phone: '0000000000',
            name: 'Администратор',
            email: 'not-exist@example.com',
            password: 'password',
            type: Employee::TYPE_ADMIN,
        ));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        User::truncate();
    }
};
