<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Housing extends Model
{
    use HasFactory;

    public const STATUS_CREATED = 1;
    public const STATUS_ON_MODERATION = 2;
    public const STATUS_PUBLISHED = 3;
    public const STATUS_ARCHIVED = 4;

    protected $fillable = [
        'price',
        'housing_category_id',
        'employee_id',
        'region_id',
        'address',
        'giving_type',
        'status',
    ];

    public function scopeCreated(Builder $query)
    {
        $query->where('status', self::STATUS_CREATED);
    }

    public function scopeOnModeration(Builder $query)
    {
        $query->where('status', self::STATUS_ON_MODERATION);
    }

    public function scopePublished(Builder $query)
    {
        $query->where('status', self::STATUS_PUBLISHED);
    }

    public function scopeArchived(Builder $query)
    {
        $query->where('status', self::STATUS_ARCHIVED);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function housingCategory(): BelongsTo
    {
        return $this->belongsTo(HousingCategory::class);
    }

    public function characteristics(): BelongsToMany
    {
        return $this->belongsToMany(Characteristic::class, 'housing_characteristics')
            ->withPivot('value');
    }

    public function givingTypeSlug(): HasOne
    {
        return $this->hasOne(GivingType::class, 'id', 'giving_type');
    }

    public function housingAssets(): HasMany
    {
        return $this->hasMany(HousingAsset::class);
    }
}
