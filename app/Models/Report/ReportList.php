<?php

namespace App\Models\Report;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ReportList extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'report.report_list';

    protected $fillable = [
        'user_id',
        'status_id',
        'no_ticket',
        'note',
        'maintenance_by',
        'survey_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function segments()
    {
        return $this->hasMany(ReportSegment::class, 'report_id');
    }

    public function buildings()
    {
        return $this->hasMany(ReportBuilding::class, 'report_id');
    }
}
