<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Characteristic extends Model
{
    use HasFactory;

    public const TYPE_BOOL   = 1;
    public const TYPE_ENUM   = 2;
    public const TYPE_STRING = 3;
    public const TYPE_NUMBER = 4;

    protected $fillable = [
        'characteristic_category_id',
        'name',
        'label',
        'type',
        'multi',
        'required',
        'sort',
    ];

    public $timestamps = false;

    public function characteristicCategory(): BelongsTo
    {
        return $this->belongsTo(CharacteristicCategory::class);
    }

    public function housings(): BelongsToMany
    {
        return $this->belongsToMany(Housing::class, 'housing_characteristics')
            ->withPivot('value');
    }

    public function options(): HasMany
    {
        return $this->hasMany(CharacteristicOption::class);
    }
}
