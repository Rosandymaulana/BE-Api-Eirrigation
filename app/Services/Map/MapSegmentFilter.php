<?php

namespace App\Services\Map;

use App\Services\ApiFilter;

class MapSegmentFilter extends ApiFilter
{
    protected $safeParms = [
        'irrigation_id' => ['eq', 'ne'],
        'irrigation_section_id' => ['eq', 'ne'],
        'name' => ['eq', 'ne'],
        'length' => ['eq', 'ne'],
        'center_point' => ['eq', 'ne'],
        'geom' => ['eq', 'ne'],
    ];

    protected $columnMap = [
        'irrigation_id' => 'irrigation_id',
        'irrigation_section_id' => 'irrigation_section_id',
        'name' => 'name',
        'length' => 'length',
        'center_point' => 'center_point',
        'geom' => 'geom',
    ];

    protected $operatorMap = [
        'eq' => '=', // Sama dengan
        'ne' => '!=', // Tidak sama dengan
        'lt' => '<', // Kurang dari
        'gt' => '>',  // Lebih dari
    ];
}
