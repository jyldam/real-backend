<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CharacteristicCategory extends Model
{
    use HasFactory;

    public function characteristics(): HasMany
    {
        return $this->hasMany(Characteristic::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(CharacteristicCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(CharacteristicCategory::class, 'parent_id');
    }
}
