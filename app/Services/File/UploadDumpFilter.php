<?php

namespace App\Services\File;

use App\Services\ApiFilter;

class UploadDumpFilter extends ApiFilter
{
    protected $safeParms = [
        "filename" => ['eq', 'ne'],
        "file_type" => ['eq', 'ne'],
        "size" => ['eq', 'ne'],
        "folder" => ['eq', 'ne'],
        "rel_path" => ['eq', 'ne'],
        "uploader_ip" => ['eq', 'ne'],
        "uploader_status" => ['eq', 'ne'],
    ];

    protected $columnMap = [
        "filename" => "filename",
        "file_type" => "file_type",
        "size" => "size",
        "folder" => "folder",
        "rel_path" => "rel_path",
        "uploader_ip" => "uploader_ip",
        "uploader_status" => "uploader_status",
    ];

    protected $operatorMap = [
        'eq' => '=', // Sama dengan
        'ne' => '!=', // Tidak sama dengan
        'lt' => '<', // Kurang dari
        'gt' => '>',  // Lebih dari
    ];
}
