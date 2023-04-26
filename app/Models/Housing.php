<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Housing extends Model
{
    use HasFactory;

    public const STATUS_CREATED = 1;
    public const STATUS_ON_MODERATION = 2;
    public const STATUS_PUBLISHED = 3;
    public const STATUS_ARCHIVED = 4;

    public const GIVING_TYPE_RENT = 1;
    public const GIVING_TYPE_SALE = 2;

    protected $fillable = [
        'price',
        'employee_id',
        'region_id',
        'address',
        'giving_type',
        'status',
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
