<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportPhotoRepairBuilding extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'report.report_photo_repair_building';

    protected $fillable = [
        'report_building_id',
        'upload_dump_id',
        'filename',
        'file_url'
    ];

    public function report_building()
    {
        return $this->belongsTo(ReportBuilding::class, 'report_building_id');
    }
}
