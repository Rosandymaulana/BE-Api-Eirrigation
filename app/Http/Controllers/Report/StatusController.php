<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Resources\Report\StatusResource;
use App\Models\Report\Status;
use App\Services\Report\StatusFilter;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\QueryBuilder;

class StatusController extends Controller
{
    public function index(Request $request)
    {
        $statusFilter = new StatusFilter();
        $queryItems = $statusFilter->transform($request);

        $query = QueryBuilder::for(Status::class)
            ->allowedSorts([
                'id', 'name', 'desc', 'created_at', 'updated_at'
            ]);

        foreach ($queryItems as $filter) {
            $query->where($filter[0], $filter[1], $filter[2]);
        }

        if ($request->has('limit')) {
            $status = $query->paginate($request->query('limit'));
        } else {
            $status = $query->paginate();
        }

        $status->getCollection()->transform(function ($status) {
            return $status;
        });

        return StatusResource::collection($status);
    }

    public function show($id)
    {
        $statusId = Status::findOrFail($id);

        return new StatusResource($statusId);
    }

    public function destroy($id)
    {
        try {
            $status = Status::findOrFail($id);
            $status->delete();

            return response()->json([
                'message' => 'Status deleted successfully',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Status not found with provided ID',
                'message' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete Status',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
