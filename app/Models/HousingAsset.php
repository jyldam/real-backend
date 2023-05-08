<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HousingAsset extends Model
{
    use HasFactory;

    const TYPE_REGULAR_IMAGE = 0;
    const TYPE_LAYOUT_IMAGE = 1;

    protected $fillable = [
        'housing_id',
        'url',
        'type',
    ];
}
