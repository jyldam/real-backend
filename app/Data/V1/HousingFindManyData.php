<?php

namespace App\Data\V1;

use App\Models\Housing;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Exists;

#[MapInputName(SnakeCaseMapper::class)]
class HousingFindManyData extends Data
{
    public function __construct(
        #[In(
            Housing::STATUS_CREATED,
            Housing::STATUS_ON_MODERATION,
            Housing::STATUS_PUBLISHED,
            Housing::STATUS_ARCHIVED,
        )]
        public ?int $status,

        public ?int $givingType,

        public ?int $housingCategoryId,

        public ?array $characteristics,

        #[Exists('employees', 'id')]
        public ?int $employeeId,

        public ?string $address,

        public ?array $price,

        #[Max(100)]
        public ?int $perPage,
    ) {}
}
