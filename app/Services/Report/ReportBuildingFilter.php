<?php

namespace App\Services\Report;

use App\Services\ApiFilter;

class ReportBuildingFilter extends ApiFilter
{
    protected $safeParms = [
        "report_id" => ['eq', 'ne'],
        "building_id" => ['eq', 'ne'],
        "level" => ['eq', 'ne'],
        "type" => ['eq', 'ne'],
        "rate" => ['eq', 'ne'],
        "comment" => ['eq', 'ne'],
    ];

    protected $columnMap = [
        "report_id" => "report_id",
        "building_id" => "building_id",
        "level" => "level",
        "type" => "type",
        "rate" => "rate",
        "comment" => "comment",
    ];

    protected $operatorMap = [
        'eq' => '=', // Sama dengan
        'ne' => '!=', // Tidak sama dengan
        'lt' => '<', // Kurang dari
        'gt' => '>',  // Lebih dari
    ];
}
