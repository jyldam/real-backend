<?php

namespace App\Data\V1;

use App\Models\CallBack;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\RequiredIf;

#[MapInputName(SnakeCaseMapper::class)]
class CallBackCreateData extends Data
{
    public function __construct(
        #[In(
            CallBack::TYPE_HOUSING_CALL_BACK,
            CallBack::TYPE_DIDNT_GET_THROUGH_CALLBACK
        )]
        public int    $type,

        #[Min(10), Max(10)]
        public string $phone,

        #[Exists('employees', 'id')]
        public int    $employeeId,

        #[RequiredIf('type', [CallBack::TYPE_HOUSING_CALL_BACK, CallBack::TYPE_DIDNT_GET_THROUGH_CALLBACK])]
        public ?int   $housingId = null,
    ) {}

    public static function attributes(): array
    {
        return [
            'type'       => 'тип',
            'housing_id' => 'объявление',
            'phone'      => 'телефон',
        ];
    }
}
