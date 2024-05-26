<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDistrict extends Model
{
    use HasFactory;
    protected $table = 'map.sub_district';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'city_id',
        'district_id',
        'name',
        'type',
        'area_km2',
        'created_at',
        'updated_at',
        'geom'
    ];
}
