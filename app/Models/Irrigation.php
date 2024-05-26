<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Irrigation extends Model
{
    use HasFactory;

    protected $fillable = [
        'district_id',
        'sub_district_id',
        'length',
        'width',
        'geom',
        'type',
        'name',
        'condition',
        'canal'
    ];
}
