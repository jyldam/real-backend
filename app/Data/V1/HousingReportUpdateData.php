<?php

namespace App\Data\V1;

use Spatie\LaravelData\Data;
use App\Models\HousingReport;
use Spatie\LaravelData\Attributes\Validation\In;

class HousingReportUpdateData extends Data
{
    public function __construct(
        #[In(
            HousingReport::STATUS_CREATED,
            HousingReport::STATUS_RESOLVED,
            HousingReport::STATUS_ARCHIVED,
        )]
        public int $status,
    ) {}

    public static function attributes(): array
    {
        return [
            'status' => 'статус',
        ];
    }
}
