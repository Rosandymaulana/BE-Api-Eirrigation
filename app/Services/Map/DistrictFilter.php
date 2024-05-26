<?php

namespace App\Services\Map;

use App\Services\ApiFilter;

class DistrictFilter extends ApiFilter
{
    protected $safeParms = [
        'city_id' => ['eq', 'ne'],
        'name' => ['eq'],
    ];

    protected $columnMap = [
        'city_id' => 'city_id',
        'name' => 'name'
    ];

    protected $operatorMap = [
        'eq' => '=', // Sama dengan
        'ne' => '!=', // Tidak sama dengan
        'lt' => '<', // Kurang dari
        'gt' => '>',  // Lebih dari
    ];
}
