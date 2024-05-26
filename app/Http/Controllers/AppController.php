<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Segment;
use Illuminate\Support\Facades\DB;

class AppController extends Controller
{
    function close_segments(Request $request) {
        $latitude = (float)$request->input('lat');
        $longitude = (float)$request->input('long');
        $close_segment = DB::select("SELECT
            id,
            name,
            geojson,
            public.ST_Distance(geom, public.geography(public.ST_SetSRID(public.ST_MakePoint($longitude, $latitude), 4326))) AS distance
        FROM
            map.irrigations_segment
        WHERE
            public.ST_Distance(geom, public.geography(public.ST_SetSRID(public.ST_MakePoint($longitude, $latitude), 4326)))<=100
        ORDER BY
            distance;");
        return response()->json($close_segment);
    }
    function check_valid_cookie() {
        return null;
    }
    function segments_by_user_id(Request $request) {
        $userId = auth()->user()->id;
        $latitude = (float)$request->input('lat');
        $longitude = (float)$request->input('long');
        $segments = DB::select("SELECT
            report.report_segment.segment_id, report.report_segment.level, 
            map.irrigations_segment.geojson, report.status.name as status, 
            map.irrigations.name as irrigation, map.irrigations.type as canal,
            public.ST_Distance(map.irrigations_segment.geom, public.geography(public.ST_SetSRID(public.ST_MakePoint($longitude, $latitude), 4326))) AS distance
        FROM
            report.report_list 
        inner join report.status on report.report_list.status_id = report.status.id 
        inner join report.report_segment on report.report_list.id = report.report_segment.report_id 
        inner join map.irrigations_segment on report.report_segment.segment_id = map.irrigations_segment.id 
        inner join map.irrigations on map.irrigations_segment.irrigation_id = map.irrigations.id 
        where 
            report.report_list.user_id = '$userId'
            AND
            public.ST_Distance(map.irrigations_segment.geom, public.geography(public.ST_SetSRID(public.ST_MakePoint($longitude, $latitude), 4326)))<=100
        ");
        return response()->json($segments);
    }
}
