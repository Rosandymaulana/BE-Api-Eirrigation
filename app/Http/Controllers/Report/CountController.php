<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Resources\Report\CountResource;
use App\Models\Report\ReportList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountController extends Controller
{
    public function index()
    {
        $statusCounts = ReportList::select('status_id', DB::raw('COUNT(*) as count'))
            ->groupBy('status_id')
            ->get();

        $formattedCounts = [
            'PROG' => 0,
            'FOLUP' => 0,
            'DONE' => 0,
        ];

        foreach ($statusCounts as $count) {
            $formattedCounts[$count->status_id] = $count->count;
        }

        return response()->json(['data' => $formattedCounts]);
    }
}
