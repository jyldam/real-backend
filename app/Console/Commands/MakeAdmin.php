<?php

namespace App\Console\Commands;

use Throwable;
use App\Models\Employee;
use App\Mail\AdminCreated;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use App\Data\V1\EmployeeCreateData;
use App\Services\V1\EmployeeService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes new admin employee';

    public function __construct(
        private EmployeeService $employeeService
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $phone = $this->ask('Телефона без "+7". Например: 7778889900');
        $name = $this->ask('Имя');
        $email = $this->ask('Электронная почта (user@example.com)');
        $password = Str::password(8, symbols: false);
        $sendEmail = $this->ask("Отправить данные на почту {$email}? (yes/no)", 'yes');

        $data = new EmployeeCreateData(
            phone: $phone,
            name: $name,
            email: $email,
            password: $password,
            type: Employee::TYPE_ADMIN,
        );

        try {
            EmployeeCreateData::validate($data);
        } catch (ValidationException $exception) {
            foreach ($exception->errors() as $errors) {
                foreach ($errors as $error) {
                    $this->error($error);
                }
            }
            return 1;
        }

        try {
            $employee = $this->employeeService->create($data);
            if (strtolower($sendEmail) === 'yes') {
                Mail::to($employee->user)->send(new AdminCreated($employee->user->phone, $password));
            }

            $this->info("Администратор успешно создан. На указанную почту {$email} отправлено письмо с данными для входа.");
            $this->info('Данные для входа:');
            $this->info(maskPhone($phone), 1);
            $this->info($password, 1);
            return 0;
        } catch (Throwable $exception) {
            if (isset($employee)) {
                $employee->user()->delete();
            }
            $this->error('Не удалось создать администратора. Причина: ' . $exception->getMessage());
            return 1;
        }
    }
}
