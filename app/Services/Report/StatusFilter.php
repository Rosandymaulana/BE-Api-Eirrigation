<?php

namespace App\Services\Report;

use App\Services\ApiFilter;

class StatusFilter extends ApiFilter
{
    protected $safeParms = [
        "id" => ['eq', 'ne'],
        "name" => ['eq', 'ne'],
        "desc" => ['eq', 'ne'],
    ];

    protected $columnMap = [
        "id" => "id",
        "name" => "name",
        "desc" => "desc",
    ];

    protected $operatorMap = [
        'eq' => '=', // Sama dengan
        'ne' => '!=', // Tidak sama dengan
        'lt' => '<', // Kurang dari
        'gt' => '>',  // Lebih dari
    ];
}
