<?php

namespace App\Services\Map;

use App\Services\ApiFilter;

class DaerahIrigasiFilter extends ApiFilter
{
    protected $safeParms = [
        'sub_district_id' => ['eq', 'ne'],
        'name_di' => ['eq', 'ne'],
        'status' => ['eq', 'ne'],
        'area_ha' => ['eq', 'ne'],
        'information' => ['eq', 'ne'],
        'created_at' => ['eq', 'ne'],
        'updated_at' => ['eq', 'ne'],
        'geojson' => ['eq', 'ne'],
    ];

    protected $columnMap = [
        'sub_district_id' => 'sub_district_id',
        'name_di' => 'name_di',
        'status' => 'status',
        'area_ha' => 'area_ha',
        'information' => 'information',
        'created_at' => 'created_at',
        'updated_at' => 'updated_at',
        'geojson' => 'geojson',
    ];

    protected $operatorMap = [
        'eq' => '=', // Sama dengan
        'ne' => '!=', // Tidak sama dengan
        'lt' => '<', // Kurang dari
        'gt' => '>',  // Lebih dari
    ];
}
