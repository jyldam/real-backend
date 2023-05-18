<?php

namespace App\Data\V1;

use App\Models\Employee;
use Spatie\LaravelData\Data;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Image;
use Spatie\LaravelData\Attributes\Validation\NotIn;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Attributes\Validation\CurrentPassword;

class EmployeeCreateData extends Data
{
    public function __construct(
        #[Min(10)]
        #[Max(10)]
        #[Unique('users', 'phone')]
        public string       $phone,

        #[Min(2)]
        public string       $name,

        #[Email]
        #[Unique('users', 'email')]
        public string       $email,

        #[CurrentPassword]
        public string       $password,

        #[Image]
        public UploadedFile $avatar,

        #[NotIn(Employee::TYPE_ADMIN)]
        #[In(
            Employee::TYPE_REALTOR,
            Employee::TYPE_MODERATOR
        )]
        public int          $type,
    ) {}

    public static function authorize(): bool
    {
        return employee()->isAdmin();
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
