<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Resources\Report\ReportBuildingResource;
use App\Models\Report\ReportBuilding;
use App\Services\Report\ReportBuildingFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Validation\ValidationException;

class ReportBuildingController extends Controller
{
    public function index(Request $request)
    {
        $reportSegmentFilter = new ReportBuildingFilter();
        $queryItems = $reportSegmentFilter->transform($request);

        $query = QueryBuilder::for(ReportBuilding::class)
            ->allowedSorts([
                'id',
                'report_id',
                'building_id',
                'level',
                'type',
                'rate',
                'comment',
                'created_at',
                'updated_at',
            ]);

        foreach ($queryItems as $filter) {
            $query->where($filter[0], $filter[1], $filter[2]);
        }

        if ($request->has('limit')) {
            $reportSegment = $query->paginate($request->query('limit'));
        } else {
            $reportSegment = $query->paginate();
        }

        $reportSegment->getCollection()->transform(function ($reportSegment) {
            return $reportSegment;
        });

        return ReportBuildingResource::collection($reportSegment);
    }

    public function show($id)
    {
        $reportSegmentId = ReportBuilding::findOrFail($id);

        return new ReportBuildingResource($reportSegmentId);
    }

    public function update(Request $request, $id)
    {
        try {
            $segment = ReportBuilding::findOrFail($id);

            $validatedData = $request->validate([
                'level' => 'required',
            ]);

            $segment->update($validatedData);

            return response()->json([
                'message' => 'Building updated successfully',
                'data' => new ReportBuildingResource($segment),
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update building',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
