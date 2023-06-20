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
use Spatie\LaravelData\Support\Validation\References\RouteParameterReference;

class EmployeeUpdateData extends Data
{
    public function __construct(
        #[Min(10)]
        #[Max(10)]
        #[Unique('users', 'phone', ignore: new RouteParameterReference('employee', 'user_id'))]
        public string        $phone,

        #[Min(2)]
        public string        $name,

        #[Email]
        #[Unique('users', 'email', ignore: new RouteParameterReference('employee', 'user_id'))]
        public string        $email,

        #[In(
            Employee::TYPE_ADMIN,
            Employee::TYPE_REALTOR,
            Employee::TYPE_MODERATOR
        )]
        public ?int          $type,

        #[Min(8)]
        public ?string       $password,

        #[Image]
        public ?UploadedFile $avatar,
    ) {}

    public static function attributes(): array
    {
        return [
            'type' => 'тип',
        ];
    }
}
