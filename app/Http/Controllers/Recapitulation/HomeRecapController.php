<?php

namespace App\Http\Controllers\Recapitulation;

use App\Http\Controllers\Controller;
use App\Models\Map\BangunanIrigasi;
use App\Models\Map\DaerahIrigasi;
use App\Models\Map\MapList;
use App\Models\Report\ReportBuilding;
use App\Models\Report\ReportList;
use App\Models\Report\ReportSegment;

class HomeRecapController extends Controller
{
    public function index()
    {
        $count_report_prog = ReportList::where('status_id', 'PROG')->count();
        $count_report_folup = ReportList::where('status_id', 'FOLUP')->count();
        $count_report_done = ReportList::where('status_id', 'DONE')->count();

        $total_saluran_irigasi_primer = MapList::where('type', 'Primer')->count();
        $total_saluran_irigasi_sekunder = MapList::where('type', 'Sekunder')->count();
        $total_saluran_irigasi_tersier = MapList::where('type', 'Tersier')->count();

        $count_segment_ringan = ReportSegment::where('level', 'RINGAN')->count();
        $count_segment_sedang = ReportSegment::where('level', 'SEDANG')->count();
        $count_segment_berat = ReportSegment::where('level', 'BERAT')->count();

        $count_building_ringan = ReportBuilding::where('level', 'RINGAN')->count();
        $count_building_sedang = ReportBuilding::where('level', 'SEDANG')->count();
        $count_building_berat = ReportBuilding::where('level', 'BERAT')->count();

        $total_daerah_irigasi = DaerahIrigasi::count();
        $total_bangunan_irigasi = BangunanIrigasi::count();

        $data = [
            'reports' => [
                'progress' => $count_report_prog,
                'follow_up' => $count_report_folup,
                'done' => $count_report_done,
            ],
            'segments' => [
                'ringan' => $count_segment_ringan + $count_building_ringan,
                'sedang' => $count_segment_sedang + $count_building_sedang,
                'berat' => $count_segment_berat + $count_building_berat,
            ],
            'irrigation' => [
                'saluran_primer' => $total_saluran_irigasi_primer,
                'saluran_sekunder' => $total_saluran_irigasi_sekunder,
                'saluran_tersier' => $total_saluran_irigasi_tersier,
                'total_areas' => $total_daerah_irigasi,
                'total_building' => $total_bangunan_irigasi,
            ],
        ];

        return response()->json(
            [
                'status' => 'success',
                'data' => $data
            ],
            200
        );
    }
}
