<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaerahIrigasi extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'map.irrigations_area';

    protected $fillable = [
        'sub_district_id',
        'name_di',
        'status',
        'area_ha',
        'information',
        'created_at',
        'updated_at',
        'geom',
    ];

    protected $casts = [
        'area_ha' => 'float',
    ];
}
