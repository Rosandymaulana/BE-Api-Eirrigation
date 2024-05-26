<?php

namespace App\Models\Map;

use App\Models\District;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class MapList extends Model
{
    use HasFactory;
    protected $table = 'map.irrigations';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'district_id',
        'sub_district_id',
        'name',
        'type',
        'length',
        'created_at',
        'updated_at',
        'geom',
        'geojson'
    ];

    protected $casts = [
        'length' => 'float',
    ];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function sub_district()
    {
        return $this->belongsTo(SubDistrict::class, 'sub_district_id');
    }
}
