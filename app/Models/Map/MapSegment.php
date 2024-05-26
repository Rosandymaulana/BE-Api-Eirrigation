<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class MapSegment extends Model
{
    use HasFactory;
    protected $table = 'map.irrigations_segment';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'irrigation_id',
        'irrigation_section_id',
        'name',
        'length',
        'center_point',
        'created_at',
        'updated_at',
        'geom'
    ];

    protected $casts = [
        'length' => 'float',
    ];

    public function irrigation()
    {
        return $this->belongsTo(MapList::class, 'irrigation_id');
    }
}
