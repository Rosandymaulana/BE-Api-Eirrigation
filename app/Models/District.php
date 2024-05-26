<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $table = 'map.district';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'city_id',
    ];
}
