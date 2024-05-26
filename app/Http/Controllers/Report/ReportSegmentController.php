<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Resources\Report\ReportSegmentResource;
use App\Models\Report\ReportSegment;
use App\Services\Report\ReportSegmentFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Validation\ValidationException;

class ReportSegmentController extends Controller
{
    public function index(Request $request)
    {
        $reportSegmentFilter = new ReportSegmentFilter();
        $queryItems = $reportSegmentFilter->transform($request);

        $query = QueryBuilder::for(ReportSegment::class)
            ->allowedSorts([
                'id',
                'report_id',
                'segment_id',
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

        return ReportSegmentResource::collection($reportSegment);
    }

    public function show($id)
    {
        $reportSegmentId = ReportSegment::findOrFail($id);

        return new ReportSegmentResource($reportSegmentId);
    }

    public function update(Request $request, $id)
    {
        try {
            $segment = ReportSegment::findOrFail($id);

            $validatedData = $request->validate([
                'level' => 'required',
            ]);

            $segment->update($validatedData);

            return response()->json([
                'message' => 'Segment updated successfully',
                'data' => new ReportSegmentResource($segment),
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update segment',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
