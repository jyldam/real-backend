<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HousingFilter extends Model
{
    use HasFactory;

    public const TYPE_RANGE = 1;
    public const TYPE_ENUM  = 2;
    public const TYPE_BOOL  = 2;
}
