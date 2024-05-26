<?php

namespace App\Http\Controllers\Map;

use App\Http\Controllers\Controller;
use App\Http\Resources\Map\MapSegmentResource;
use App\Models\Map\MapSegment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapSegmentController extends Controller
{
    public function index()
    {
        $segment = MapSegment::paginate();

        return MapSegmentResource::collection($segment);
    }
}
