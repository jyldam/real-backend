<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HousingReport extends Model
{
    use HasFactory;

    public const STATUS_CREATED  = 1;
    public const STATUS_RESOLVED = 2;
    public const STATUS_ARCHIVED = 3;

    protected $fillable = [
        'housing_report_type_id',
        'housing_id',
        'value',
        'status',
        'ip',
    ];

    protected $casts = [
        'value' => 'collection',
    ];

    public function housingReportType(): BelongsTo
    {
        return $this->belongsTo(HousingReportType::class);
    }
}
