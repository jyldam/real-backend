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
use Spatie\LaravelData\Attributes\Validation\Unique;

class EmployeeCreateData extends Data
{
    public function __construct(
        #[Min(10)]
        #[Max(10)]
        #[Unique('users', 'phone')]
        public string        $phone,

        #[Min(2)]
        public string        $name,

        #[Email]
        #[Unique('users', 'email')]
        public string        $email,

        #[Min(8)]
        public string        $password,

        #[In(
            Employee::TYPE_ADMIN,
            Employee::TYPE_REALTOR,
            Employee::TYPE_MODERATOR
        )]
        public int           $type,

        #[Image]
        public ?UploadedFile $avatar = null,
    ) {}

    public static function authorize(): bool
    {
        return employee()->isAdmin();
    }

    public static function attributes(): array
    {
        return [
            'type'  => 'тип',
            'phone' => 'телефон',
            'name'  => 'имя',
            'email' => 'электронная почта',
        ];
    }
}
