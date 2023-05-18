<?php

namespace App\Data\V1\HousingCreateData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Attributes\Validation\Exists;

#[MapInputName(SnakeCaseMapper::class)]
class CharacteristicData extends Data
{
    public function __construct(
        #[Exists('characteristics', 'id')]
        public int    $characteristicId,

        public string $value,
    ) {}

    public static function attributes(): array
    {
        return [
            'characteristic_id' => 'характеристики',
            'value'             => 'значения характеристики',
        ];
    }
}
