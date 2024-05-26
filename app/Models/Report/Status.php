<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $table = 'report.status';
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'desc',
        'name',
        'created_at',
        'updated_at',
    ];
}
