<?php

namespace App\Http\Controllers\About;

use App\Http\Controllers\Controller;
use App\Models\Map\BangunanIrigasi;
use App\Models\Map\DaerahIrigasi;
use App\Models\Map\MapList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfoAreaController extends Controller
{
    public function index()
    {
        $total_bangunan_irigasi = BangunanIrigasi::count();

        $total_daerah_irigasi = DaerahIrigasi::count();
        $total_luas_daerah_irigasi = DaerahIrigasi::take(3)->sum('area_ha');
        // $totalArea =
        //     DB::table(DB::raw('(SELECT area_ha AS total_area_ha FROM map.irrigations_area) AS limited_area_data'))
        //     ->selectRaw('SUM(total_area_ha) AS area_ha')
        //     ->first();

        $totalSaluranIrigasi = MapList::count();
        $total_saluran_irigasi_primer = MapList::where('type', 'Primer')->count();
        $total_saluran_irigasi_sekunder = MapList::where('type', 'Sekunder')->count();
        $total_saluran_irigasi_tersier = MapList::where('type', 'Tersier')->count();

        $data = [
            'total_bangunan_irigasi' => $total_bangunan_irigasi,
            'total_daerah_irigasi' => $total_daerah_irigasi,
            'total_luas_daerah_irigasi' => $total_luas_daerah_irigasi,
            'total_saluran_irigasi' => $totalSaluranIrigasi,
            'total_saluran_irigasi_primer' => $total_saluran_irigasi_primer,
            'total_saluran_irigasi_sekunder' => $total_saluran_irigasi_sekunder,
            'total_saluran_irigasi_tersier' => $total_saluran_irigasi_tersier,
        ];


        return response()->json([
            'data' => $data
        ]);
    }
}
