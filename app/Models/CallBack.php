<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CallBack extends Model
{
    use HasFactory;

    public const TYPE_HOUSING_CALL_BACK = 1;
    public const TYPE_DIDNT_GET_THROUGH_CALLBACK = 2;

    protected $fillable = [
        'employee_id',
        'phone',
        'extra',
        'type',
    ];

    protected $casts = [
        'extra' => 'collection',
    ];

    public static function allTypes()
    {
        return [self::TYPE_HOUSING_CALL_BACK, self::TYPE_DIDNT_GET_THROUGH_CALLBACK];
    }
}
