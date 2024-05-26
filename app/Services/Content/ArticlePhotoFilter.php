<?php

namespace App\Services\Content;

use App\Services\ApiFilter;

class ArticlePhotoFilter extends ApiFilter
{
    protected $safeParms = [
        'id' => ['eq', 'ne'],
        'article_id' => ['eq', 'ne'],
        'upload_dump_id' => ['eq', 'ne'],
        'filename' => ['eq', 'ne'],
        'file_url' => ['eq', 'ne'],
    ];

    protected $columnMap = [
        'article_id' => 'article_id',
        'upload_dump_id' => 'upload_dump_id',
        'filename' => 'filename',
        'file_url' => 'file_url',
    ];

    protected $operatorMap = [
        'eq' => '=', // Sama dengan
        'ne' => '!=', // Tidak sama dengan
        'lt' => '<', // Kurang dari
        'gt' => '>',  // Lebih dari
    ];
}
