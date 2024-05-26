<?php

namespace App\Services\User;

use App\Services\ApiFilter;

class UserSectionFilter extends ApiFilter
{
    protected $safeParms = [
        'urole_id' => ['eq', 'ne'],
        'username' => ['eq', 'ne'],
        'email' => ['eq', 'ne'],
        'fullname' => ['eq', 'ne'],
        'shortname' => ['eq', 'ne'],
        'phone' => ['eq', 'ne'],
        'code' => ['eq', 'ne'],
    ];

    protected $columnMap = [
        'username' => 'username',
        'email' => 'email',
        'password' => 'password',
        'fullname' => 'fullname',
        'shortname' => 'shortname',
        'avatar' => 'avatar',
        'phone' => 'phone',
        'status' => 'status',
    ];

    protected $operatorMap = [
        'eq' => '=', // Sama dengan
        'ne' => '!=', // Tidak sama dengan
        'lt' => '<', // Kurang dari
        'gt' => '>',  // Lebih dari
    ];
}
