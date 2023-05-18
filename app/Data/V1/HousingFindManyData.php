<?php

namespace App\Data\V1;

use App\Models\Housing;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Sometimes;

#[MapInputName(SnakeCaseMapper::class)]
class HousingFindManyData extends Data
{
    public function __construct(
        #[Sometimes]
        #[In(
            Housing::STATUS_CREATED,
            Housing::STATUS_ON_MODERATION,
            Housing::STATUS_PUBLISHED,
            Housing::STATUS_ARCHIVED,
        )]
        public ?int   $status,

        #[Sometimes]
        #[Max(100)]
        public ?int   $perPage,

        #[Sometimes]
        public ?int   $givingType,

        #[Sometimes]
        public ?int   $housingCategoryId,

        #[Sometimes]
        public ?array $characteristics,
    ) {}
}
