<?php

namespace App\Models\File;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class UploadDump extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'file.upload_dump';

    protected $fillable  = [
        'filename',
        'file_type',
        'size',
        'folder',
        'file_url',
        'uploader_ip',
        'uploader_status',
        'created_at',
        'updated_at',
    ];
}
