<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Characteristic extends Model
{
    use HasFactory;

    protected $fillable = [
        'characteristic_category_id',
        'name',
        'label',
        'sort',
    ];

    public function characteristicCategory(): BelongsTo
    {
        return $this->belongsTo(CharacteristicCategory::class);
    }
}
