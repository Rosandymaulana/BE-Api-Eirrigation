<?php

namespace App\Http\Controllers\Map;

use App\Http\Controllers\Controller;
use App\Http\Resources\Map\SectionResource;
use App\Models\Map\MapSection;
use Illuminate\Support\Facades\DB;

class IrrigationSectionController extends Controller
{
    public function index()
    {
        $sections = MapSection::paginate();

        $sections->getCollection()->transform(function ($item) {
            $geojson = DB::selectOne('SELECT ST_AsGeoJSON(ST_Transform(geom, 4326)) as geojson FROM master.irrigations_section WHERE id = ?', [$item->id])->geojson;
            $item->geojson = $geojson;
            return $item;
        });
        return SectionResource::collection($sections);
    }
}
