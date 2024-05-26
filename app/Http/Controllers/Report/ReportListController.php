<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Resources\Report\ReportListResource;
use App\Models\Report\ReportList;
use App\Services\Report\ReportListFilter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Validation\ValidationException;

class ReportListController extends Controller
{
    public function index(Request $request)
    {
        $reportFilter = new ReportListFilter();
        $queryItems = $reportFilter->transform($request);

        $query = QueryBuilder::for(ReportList::class)
            ->allowedSorts([
                'user_id', 'status_id', 'no_ticket', 'type_list', 'note', 'maintenance_by', 'created_at', 'updated_at'
            ]);

        foreach ($queryItems as $filter) {
            $query->where($filter[0], $filter[1], $filter[2]);
        }

        if ($request->has('search')) {

            $query->where('user_id', 'like', '%' . $request->input('search.user_id') . '%');
            $query->where('status_id', 'like', '%' . $request->input('search.status_id') . '%');
            $query->where('no_ticket', 'like', '%' . $request->input('search.no_ticket') . '%');

            $searchTerm = $request->input('search.user.username');
            $query->whereHas('user', function ($query) use ($searchTerm) {
                $query->where('username', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->has('limit')) {
            $reportList = $query->paginate($request->query('limit'));
        } else {
            $reportList = $query->paginate();
        }

        $reportList->getCollection()->transform(function ($reportList) {
            return $reportList;
        });

        return ReportListResource::collection($reportList);
    }

    public function show($id)
    {
        $reportListId = ReportList::findOrFail($id);

        return new ReportListResource($reportListId);
    }

    public function update(Request $request, $id)
    {
        try {
            $report = ReportList::findOrFail($id);

            $validatedData = $request->validate([
                'status_id' => 'required',
                'note' => 'sometimes',
            ]);

            $maintenanceBy = Auth::id();
            $validatedData['maintenance_by'] = $maintenanceBy;

            $report->update($validatedData);

            return response()->json([
                'message' => 'Report updated successfully',
                'data' => new ReportListResource($report),
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update Report',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $role = ReportList::findOrFail($id);
            $role->delete();

            return response()->json([
                'message' => 'Report deleted successfully',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Report not found with provided ID',
                'message' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete Report',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
