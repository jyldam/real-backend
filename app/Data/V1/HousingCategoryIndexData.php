<?php

namespace App\Data\V1;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class HousingCategoryIndexData extends Data
{
    public function __construct(
        public ?string $withHousing,

        public ?int    $givingType
    ) {}
}
