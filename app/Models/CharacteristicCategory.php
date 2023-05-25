<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CharacteristicCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mesh_name',
        'disabled',
        'sort',
        'preview_characteristics',
    ];

    protected $casts = [
        'preview_characteristics' => 'collection',
    ];

    public function characteristics(): HasMany
    {
        return $this->hasMany(Characteristic::class)->orderBy('sort');
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
