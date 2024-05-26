<?php

namespace App\Http\Controllers\Map;

use App\Http\Controllers\Controller;
use App\Http\Resources\Map\SubDistrictResource;
use App\Models\Map\SubDistrict;
use App\Services\Map\MapSectionFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SubDistrictController extends Controller
{
    public function index(Request $request)
    {
        $sectionFilter = new MapSectionFilter();
        $queryItems = $sectionFilter->transform($request); //(['column', 'operator', 'value'])

        $query = QueryBuilder::for(SubDistrict::class)
            ->allowedSorts(['name', 'type', 'area_km2', 'created_at', 'updated_at']);

        foreach ($queryItems as $filter) {
            $query->where($filter[0], $filter[1], $filter[2]);
        }

        $sub_districts = $query->get();

        $sub_districts->transform(function ($item) {
            $geojson = DB::selectOne('SELECT ST_AsGeoJSON(ST_Transform(geom, 4326)) as geojson FROM map.sub_district WHERE id = ?', [$item->id])->geojson;
            $item->geojson = $geojson;
            return $item;
        });

        return SubDistrictResource::collection($sub_districts);
    }

    public function show($id)
    {
        $subDistrict = SubDistrict::findOrFail($id);

        $geojson = DB::selectOne('SELECT ST_AsGeoJSON(ST_Transform(geom, 4326)) as geojson FROM map.sub_district WHERE id = ?', [$subDistrict->id])->geojson;
        $subDistrict->geojson = $geojson;

        return new SubDistrictResource($subDistrict);
    }
}
