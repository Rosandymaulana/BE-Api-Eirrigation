<?php

namespace App\Http\Controllers\Map;

use App\Http\Controllers\Controller;
use App\Http\Resources\Map\DaerahIrigasiResource;
use App\Models\Map\DaerahIrigasi;
use App\Services\Map\DaerahIrigasiFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class DaerahIrigasiController extends Controller
{
    public function index(Request $request)
    {
        $daerahIrigasiFilter = new DaerahIrigasiFilter();
        $queryItems = $daerahIrigasiFilter->transform($request);

        $query = QueryBuilder::for(DaerahIrigasi::class)
            ->allowedSorts([
                'sub_district_id',
                'name_di',
                'status',
                'area_ha',
                'information',
                'created_at',
                'updated_at',
            ]);

        foreach ($queryItems as $filter) {
            $query->where($filter[0], $filter[1], $filter[2]);
        }

        $daerahIrigasi = $query->get();

        $daerahIrigasi->transform(function ($item) {
            $geojson =
                DB::selectOne('SELECT *, ST_AsGeoJSON(ST_Transform(geom, 4326)) as geojson FROM map.irrigations_area WHERE id = ?', [$item->id])->geojson;
            $item->geojson = $geojson;
            return $item;
        });

        return DaerahIrigasiResource::collection($daerahIrigasi);
    }

    public function show($id)
    {
        $item = DaerahIrigasi::findOrFail($id);

        $geojson = DB::selectOne('SELECT ST_AsGeoJSON(ST_Transform(geom, 4326)) as geojson FROM map.irrigations_area WHERE id = ?', [$item->id])->geojson;
        $item->geojson = $geojson;

        return new DaerahIrigasiResource($item);
    }
}
