<?php

namespace App\Data\V1;

use App\Models\CallBack;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\RequiredIf;

class CallBackCreateData extends Data
{
    public function __construct(
        #[In(
            CallBack::TYPE_HOUSING_CALL_BACK,
            CallBack::TYPE_DIDNT_GET_THROUGH_CALLBACK
        )]
        public int    $type,

        #[RequiredIf('type', [CallBack::TYPE_HOUSING_CALL_BACK, CallBack::TYPE_DIDNT_GET_THROUGH_CALLBACK])]
        public ?int   $housing_id,

        #[Min(10), Max(10)]
        public string $phone
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
