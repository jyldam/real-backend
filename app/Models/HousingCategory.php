<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HousingCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mesh_name',
        'disabled',
        'sort',
    ];

    public function characteristicCategories(): HasMany
    {
        return $this->hasMany(CharacteristicCategory::class);
    }

    public function housings(): HasMany
    {
        return $this->hasMany(Housing::class);
    }
}
