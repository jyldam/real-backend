<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HousingAsset extends Model
{
    use HasFactory;

    public const TYPE_REGULAR_IMAGE = 1;
    public const TYPE_LAYOUT_IMAGE = 2;

    protected $fillable = [
        'housing_id',
        'url',
        'type',
    ];

    public static function allTypes()
    {
        return [self::TYPE_REGULAR_IMAGE, self::TYPE_LAYOUT_IMAGE];
    }
}
