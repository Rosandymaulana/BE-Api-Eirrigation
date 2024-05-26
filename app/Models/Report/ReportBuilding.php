<?php

namespace App\Models\Report;

use App\Models\Map\BangunanIrigasi;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportBuilding extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'report.report_building';

    protected $fillable = [
        'report_id',
        'building_id',
        'level',
        'type',
        'rate',
        'comment',
        'note'
    ];

    public function report()
    {
        return $this->belongsTo(ReportList::class, 'report_id');
    }

    public function build()
    {
        return $this->belongsTo(BangunanIrigasi::class, 'building_id');
    }

    public function report_photo_building()
    {
        return $this->hasMany(ReportPhoto::class, 'report_segment_id');
    }

    public function report_photo_repair_building()
    {
        return $this->hasMany(ReportPhotoRepairBuilding::class, 'report_building_id');
    }
}
