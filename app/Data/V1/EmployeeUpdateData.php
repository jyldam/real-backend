<?php

namespace App\Data\V1;

use App\Models\Employee;
use Spatie\LaravelData\Data;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\NotIn;
use Spatie\LaravelData\Attributes\Validation\Image;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Attributes\Validation\CurrentPassword;
use Spatie\LaravelData\Support\Validation\References\RouteParameterReference;

class EmployeeUpdateData extends Data
{
    public function __construct(
        #[Min(10)]
        #[Max(10)]
        #[Unique('users', 'phone', ignore: new RouteParameterReference('employee', 'id'))]
        public string       $phone,

        #[Min(2)]
        public string       $name,

        #[Email]
        #[Unique('users', 'email', ignore: new RouteParameterReference('employee', 'id'))]
        public string       $email,

        #[NotIn(Employee::TYPE_ADMIN)]
        #[In(
            Employee::TYPE_REALTOR,
            Employee::TYPE_MODERATOR
        )]
        public int          $type,

        #[CurrentPassword]
        public string       $password,

        #[Image]
        public UploadedFile $avatar,
    ) {}

    public static function authorize(): bool
    {
        $employee = employee();
        return $employee && ($employee->isAdmin() || $employee->id === request('employee')->id);
    }

    public static function messages(): array
    {
        return [
            'type.not_in' => 'Создание админа запрещено',
        ];
    }

    public static function attributes(): array
    {
        return [
            'type' => 'тип',
        ];
    }
}