<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportPhotoBuilding extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'report.report_photo_building';

    protected $fillable = [
        'report_building_id',
        'upload_dump_id',
        'filename',
        'file_url'
    ];

    public function report_segment()
    {
        return $this->belongsTo(ReportBuilding::class, 'report_building_id');
    }
}
