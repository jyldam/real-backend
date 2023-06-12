<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CharacteristicOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'characteristic_id',
        'name',
    ];

    public $timestamps = false;

    public function characteristic(): BelongsTo
    {
        return $this->belongsTo(Characteristic::class);
    }
}
