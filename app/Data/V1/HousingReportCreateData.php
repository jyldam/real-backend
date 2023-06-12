<?php

namespace App\Data\V1;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Attributes\Validation\Exists;

#[MapInputName(SnakeCaseMapper::class)]
class HousingReportCreateData extends Data
{
    public function __construct(
        #[Exists('housing_report_types', 'id')]
        public int $type,

        #[Exists('housings', 'id')]
        public int $housingId,

        public array $fields,
    ) {}

    public static function attributes(): array
    {
        return [
            'type'       => 'тип',
            'housing_id' => 'объявление',
        ];
    }
}
