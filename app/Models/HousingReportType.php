<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HousingReportType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rules',
        'attributes',
    ];

    protected $casts = [
        'rules'      => 'collection',
        'attributes' => 'collection',
    ];
}
