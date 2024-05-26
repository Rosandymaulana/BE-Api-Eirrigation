<?php

namespace App\Models\Spk;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'dss.criteria';

    protected $fillable = [
        'id',
        'name',
        'weight',
        'type',
    ];
}
