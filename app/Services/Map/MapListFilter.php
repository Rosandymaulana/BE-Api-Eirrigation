<?php

namespace App\Services\Map;

use App\Services\ApiFilter;

class MapListFilter extends ApiFilter
{
    protected $safeParms = [
        'id' => ['eq', 'ne'],
        'district_id' => ['eq', 'ne'],
        'sub_district_id' => ['eq', 'ne'],
        'type' => ['eq', 'ne'],
        'name' => ['eq'],
    ];

    protected $columnMap = [
        'id' => 'id',
        'district_id' => 'district_id',
        'sub_district_id' => 'sub_district_id',
        'type' => 'type',
        'name' => 'name'
    ];

    protected $operatorMap = [
        'eq' => '=', // Sama dengan
        'ne' => '!=', // Tidak sama dengan
        'lt' => '<', // Kurang dari
        'gt' => '>',  // Lebih dari
    ];
}
