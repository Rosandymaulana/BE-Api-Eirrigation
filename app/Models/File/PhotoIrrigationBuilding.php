<?php

namespace App\Models\File;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoIrrigationBuilding extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'file.photo_irrigation_building';

    protected $fillable = [
        'id',
        'building_id',
        'upload_dump_id',
        'filename',
        'file_url'
    ];
}
