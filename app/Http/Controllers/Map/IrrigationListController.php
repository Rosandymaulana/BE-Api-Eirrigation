<?php

namespace App\Http\Controllers\Map;

use App\Http\Controllers\Controller;
use App\Http\Resources\Map\ListResource;
use App\Models\Map\MapList;
use App\Services\Map\MapListFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class IrrigationListController extends Controller
{
    public function index(Request $request)
    {
        $listFilter = new MapListFilter();
        $queryItems = $listFilter->transform($request);  //(['column', 'operator', 'value'])

        $query = QueryBuilder::for(MapList::class)
            ->allowedSorts(['district_id', 'sub_district_id', 'name', 'created_at'])
            ->allowedFilters([
                AllowedFilter::exact('district_id'),
                AllowedFilter::exact('sub_district_id'),
                AllowedFilter::exact('type'),
                AllowedFilter::exact('name'),
            ]);

        foreach ($queryItems as $filter) {
            $query->where($filter[0], $filter[1], $filter[2]);
        }

        if ($request->has('limit')) {
            $irrigations_list = $query->paginate($request->query('limit'));
        } else {
            $irrigations_list = $query->paginate();
        }

        $irrigations_list->transform(function ($item) {
            $geojson =
                DB::selectOne('SELECT *, ST_AsGeoJSON(ST_Transform(geom, 4326)) as geojson FROM map.irrigations WHERE id = ?', [$item->id])->geojson;
            $item->geojson = $geojson;
            return $item;
        });

        return ListResource::collection($irrigations_list);
    }

    public function show($id)
    {
        $irrigationId = MapList::findOrFail($id);

        $geojsonResult = DB::selectOne('SELECT *, ST_AsGeoJSON(ST_Transform(geom, 4326)) as geojson FROM map.irrigations WHERE id = ?', [$irrigationId->id]);
        $irrigationId['geojson'] = $geojsonResult->geojson;

        return new ListResource($irrigationId);
    }
}
