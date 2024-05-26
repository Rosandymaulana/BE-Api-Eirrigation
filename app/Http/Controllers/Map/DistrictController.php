<?php

namespace App\Http\Controllers\Map;

use App\Http\Controllers\Controller;
use App\Http\Resources\Map\DistrictResource;
use App\Models\District;
use App\Services\Map\DistrictFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class DistrictController extends Controller
{
    public function index(Request $request)
    {
        $districtFilter = new DistrictFilter();
        $queryItems = $districtFilter->transform($request);

        $query = QueryBuilder::for(District::class)
            ->allowedSorts(['id', 'name', 'city_id', 'created_at', 'updated_at'])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('name'),
                AllowedFilter::exact('city_id')
            ]);

        foreach ($queryItems as $filter) {
            $query->where($filter[0], $filter[1], $filter[2]);
        }

        if ($request->has('limit')) {
            $district = $query->paginate($request->query('limit'));
        } else {
            $district = $query->paginate();
        }

        $district->getCollection()->transform(function ($item) {
            return $item;
        });

        return DistrictResource::collection(($district));
    }

    public function show($id)
    {
        $districtId = District::findOrFail($id);

        return new DistrictResource($districtId);
    }
}
