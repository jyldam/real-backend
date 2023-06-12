<?php

namespace App\Services\V1;

use App\Models\HousingReport;
use App\Models\HousingReportType;
use App\Data\V1\HousingReportCreateData;
use App\Data\V1\HousingReportUpdateData;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class HousingReportService
{
    /**
     * @throws ValidationException
     */
    public function create(HousingReportCreateData $data): void
    {
        $reportType = HousingReportType::query()->find($data->type);

        $validator = Validator::make(
            $data->fields,
            $reportType->rules->toArray(),
            attributes: $reportType->attributes->toArray(),
        );
        $validator->validate();

        HousingReport::query()->create([
            'housing_report_type_id' => $data->type,
            'housing_id'             => $data->housingId,
            'value'                  => $validator->validated(),
            'status'                 => HousingReport::STATUS_CREATED,
            'ip'                     => request()->ip(),
        ]);
    }

    public function ipAddressHasAccess(): bool
    {
        $reportsCount = HousingReport::query()
            ->whereDate('created_at', today())
            ->where('ip', request()->ip())
            ->count();
        return $reportsCount < 5;
    }

    public function update(HousingReportUpdateData $data, HousingReport $housingReport): void
    {
        $housingReport->update([
            'status' => $data->status,
        ]);
    }

    public function delete(HousingReport $housingReport): void
    {
        $housingReport->delete();
    }
}
