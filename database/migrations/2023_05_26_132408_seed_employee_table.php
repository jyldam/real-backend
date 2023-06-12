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
            email: 'admin@realpvl.kz',
            password: 'AdminR@le$',
            type: Employee::TYPE_ADMIN,
        ));

        $employees = [
            ['Алмагуль', '7027177387'],
            ['Самал', '7026032348'],
            ['Азамат', '7026038701', 'aza77787@mail.ru'],
            ['Мадина', '7026368798', 'aliwka09@mail.ru'],
            ['Лариса', '7023497073'],
            ['Жанар', '7057073774'],
            ['Нургуль', '7057073707', 'nurguly2014@mail.ru', Employee::TYPE_MODERATOR],
            ['Орынтай', '7057073787', 'oryntai67@gmail.com'],
            ['Меруерт', '7057073772', 'ms.baurzhankizi@mail.ru'],
            ['Регина', '7057073797', 'regina.titova.99@internet.ru'],
            ['Дархан', '7057073756', 'darhanchik1979@mail.ru'],
            ['Жомарт', '7753626091', 'moder1@realpvl.kz', Employee::TYPE_MODERATOR],
        ];

        $i = 0;

        foreach ($employees as $employee) {
            $i++;
            (new EmployeeService())->create(new EmployeeCreateData(
                phone: $employee[1],
                name: $employee[0],
                email: $employee[2] ?? "test{$i}@realpvl.kz",
                password: "re@l!{$employee[0]}",
                type: $employee[3] ?? Employee::TYPE_REALTOR,
            ));
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        User::truncate();
    }
};
