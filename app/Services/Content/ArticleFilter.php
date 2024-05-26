<?php

namespace App\Services\Content;

use App\Services\ApiFilter;

class ArticleFilter extends ApiFilter
{
    protected $safeParms = [
        'title' => ['eq', 'ne'],
        'desc' => ['eq', 'ne'],
        'name' => ['eq', 'ne'],
    ];

    protected $columnMap = [
        'title' => 'title',
        'desc' => 'desc',
        'name' => 'name',
    ];

    protected $operatorMap = [
        'eq' => '=', // Sama dengan
        'ne' => '!=', // Tidak sama dengan
        'lt' => '<', // Kurang dari
        'gt' => '>',  // Lebih dari
    ];
}
