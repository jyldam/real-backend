<?php

namespace App\Services;

use App\Models\Housing;

class HousingService
{
    public function getPublished(array $where, int|null $perPage)
    {
        return Housing::query()
            ->with([
                'region',
                'employee.user',
                'housingCategory',
                'characteristics' => fn($query) => $query->with('characteristicCategory')->orderBy('sort'),
                'givingTypeSlug',
            ])
            ->where('status', Housing::STATUS_PUBLISHED)
            ->when(@$where['giving_type'], fn($query) => $query->where('giving_type', $where['giving_type']))
            ->when(
                @$where['housing_category_id'],
                fn($query) => $query->where('housing_category_id', $where['housing_category_id'])
            )
            ->paginate($perPage ?: 30);
    }
}
