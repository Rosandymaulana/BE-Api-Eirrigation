<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $table = 'user.user_roles';
    protected $keyType = 'string';
    public $incrementing = true;

    protected $fillable = [
        'name',
        'code',
        'desc'
    ];
}
