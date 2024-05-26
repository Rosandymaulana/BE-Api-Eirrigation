<?php

namespace App\Services\User;

use App\Services\ApiFilter;

class RoleFilter extends ApiFilter
{
    protected $safeParms = [
        'code' => ['eq', 'ne'],
        'name' => ['eq', 'ne'],
        'desc' => ['eq', 'ne'],
    ];

    protected $columnMap = [
        'code' => 'code',
        'name' => 'name',
        'desc' => 'desc',
    ];

    protected $operatorMap = [
        'eq' => '=', // Sama dengan
        'ne' => '!=', // Tidak sama dengan
        'lt' => '<', // Kurang dari
        'gt' => '>',  // Lebih dari
    ];
}
