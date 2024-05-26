<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportPhotoRepair extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'report.report_photo_repair';

    protected $fillable = [
        'report_segment_id',
        'upload_dump_id',
        'filename',
        'file_url'
    ];

    public function report_segment()
    {
        return $this->belongsTo(ReportSegment::class, 'report_segment_id');
    }
}
