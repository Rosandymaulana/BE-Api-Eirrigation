<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class MapSection extends Model
{
    use HasFactory;
    protected $table = 'map.irrigations_section';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'irrigation_id',
        'name',
        'created_at',
        'updated_at',
        'geom'
    ];
}
