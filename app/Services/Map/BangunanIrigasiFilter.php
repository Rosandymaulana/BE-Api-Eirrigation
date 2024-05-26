<?php

namespace App\Services\Map;

use App\Services\ApiFilter;

class BangunanIrigasiFilter extends ApiFilter
{
    protected $safeParms = [
        'nama_bangunan' => ['eq', 'ne'],
        'tipe_saluran' => ['eq', 'ne'],
        'jarak' => ['eq', 'ne'],
        'b_saluran  ' => ['eq', 'ne'],
        'sempadan_kanan ' => ['eq', 'ne'],
        'sempadan_kiri' => ['eq', 'ne'],
        'luas_saluran' => ['eq', 'ne'],
        'sisi_terluar_kanan' => ['eq', 'ne'],
        'sisi_terluar_kiri' => ['eq', 'ne'],
        'saluran_kanan' => ['eq', 'ne'],
        'saluran_panjang_kanan' => ['eq', 'ne'],
        'saluran_kiri' => ['eq', 'ne'],
        'saluran_panjang_kiri' => ['eq', 'ne'],
    ];

    protected $columnMap = [
        'nama_bangunan' => 'nama_bangunan',
        'tipe_saluran' => 'tipe_saluran',
        'jarak' => 'jarak',
        'b_saluran  ' => 'b_saluran  ',
        'sempadan_kanan ' => 'sempadan_kanan ',
        'sempadan_kiri' => 'sempadan_kiri',
        'luas_saluran' => 'luas_saluran',
        'sisi_terluar_kanan' => 'sisi_terluar_kanan',
        'sisi_terluar_kiri' => 'sisi_terluar_kiri',
        'saluran_kanan' => 'saluran_kanan',
        'saluran_panjang_kanan' => 'saluran_panjang_kanan',
        'saluran_kiri' => 'saluran_kiri',
        'saluran_panjang_kiri' => 'saluran_panjang_kiri',
    ];

    protected $operatorMap = [
        'eq' => '=', // Sama dengan
        'ne' => '!=', // Tidak sama dengan
        'lt' => '<', // Kurang dari
        'gt' => '>',  // Lebih dari
    ];
}
