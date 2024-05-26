<?php

namespace App\Http\Controllers\Map;

use App\Http\Controllers\Controller;
use App\Http\Resources\Map\BangunanIrigasiResource;
use App\Models\Map\BangunanIrigasi;
use App\Services\Map\BangunanIrigasiFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Validation\ValidationException;

class BangunanIrigasiController extends Controller
{
    public function index(Request $request)
    {
        $bangunanIrigasiFilter = new BangunanIrigasiFilter();
        $queryItems = $bangunanIrigasiFilter->transform($request);

        $query = QueryBuilder::for(BangunanIrigasi::class)
            ->allowedSorts([
                'nama_bangunan',
                'tipe_saluran',
                'jarak',
                'b_saluran  ',
                'sempadan_kanan ',
                'sempadan_kiri',
                'luas_saluran',
                'sisi_terluar_kanan',
                'sisi_terluar_kiri',
                'saluran_kanan',
                'saluran_panjang_kanan',
                'saluran_kiri',
                'saluran_panjang_kiri',
                'keterangan',
                'created_at',
                'updated_at',
                'geom'
            ]);

        foreach ($queryItems as $filter) {
            $query->where($filter[0], $filter[1], $filter[2]);
        }

        if ($request->has('limit')) {
            $bangunanIrigasi = $query->paginate($request->query('limit'));
        } else {
            $bangunanIrigasi = $query->paginate();
        }

        return BangunanIrigasiResource::collection($bangunanIrigasi);
    }

    public function show($id)
    {
        $item = BangunanIrigasi::findOrFail($id);

        $geojson = DB::selectOne('SELECT ST_AsGeoJSON(ST_Transform(geom, 4326)) as geojson FROM map.irrigations_building WHERE id = ?', [$item->id])->geojson;
        $item->geojson = $geojson;

        return new BangunanIrigasiResource($item);
    }

    public function update(Request $request, $id)
    {
        try {
            $bangunanIrigasi = BangunanIrigasi::findOrFail($id);

            $validatedData = $request->validate([
                'nama_bangunan' => 'sometimes',
                'tipe_saluran' => 'sometimes',
                'jarak' => 'sometimes',
                'b_saluran  ' => 'sometimes',
                'sempadan_kanan ' => 'sometimes',
                'sempadan_kiri' => 'sometimes',
                'luas_saluran' => 'sometimes',
                'sisi_terluar_kanan' => 'sometimes',
                'sisi_terluar_kiri' => 'sometimes',
                'saluran_kanan' => 'sometimes',
                'saluran_panjang_kanan' => 'sometimes',
                'saluran_kiri' => 'sometimes',
                'saluran_panjang_kiri' => 'sometimes',
                'keterangan' => 'sometimes',
            ]);

            $bangunanIrigasi->update($validatedData);

            return response()->json([
                'message' => 'Bangunan Irigasi updated successfully',
                'data' => new BangunanIrigasiResource($bangunanIrigasi),
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update Bangunan Irigasi',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
