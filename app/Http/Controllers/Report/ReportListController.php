<?php

namespace App\Http\Controllers\Report;

use App\Exports\ReportBangunanExport;
use App\Exports\ReportIrrigationExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\Report\ReportListResource;
use App\Models\Report\ReportList;
use App\Services\Report\ReportListFilter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class ReportListController extends Controller
{
    public function index(Request $request)
    {
        $reportFilter = new ReportListFilter();
        $queryItems = $reportFilter->transform($request);

        $query = QueryBuilder::for(ReportList::class)
            ->with(['user', 'status', 'segments', 'buildings'])
            ->allowedSorts([
                'user_id', 'status_id', 'no_ticket', 'type_list', 'note', 'maintenance_by', 'created_at', 'updated_at'
            ]);

        foreach ($queryItems as $filter) {
            $query->where($filter[0], $filter[1], $filter[2]);
        }

        if ($request->has('search')) {
            $query->where(function ($query) use ($request) {
                foreach ($request->query('search') as $columns => $value) {
                    $columnsArray = explode(',', $columns);

                    $query->where(function ($query) use ($columnsArray, $value) {
                        foreach ($columnsArray as $column) {
                            if ($column == 'fullname' || $column == 'phone') {
                                $query->orWhereHas('user', function ($q) use ($column, $value) {
                                    $q->whereRaw('lower(' . $column . ') like ?', ['%' . strtolower($value) . '%']);
                                });
                            } elseif ($column == 'status.name') {
                                $query->orWhereHas('status', function ($q) use ($value) {
                                    $q->whereRaw('lower(name) like ?', ['%' . strtolower($value) . '%']);
                                });
                            } elseif ($column == 'nama_bangunan') {
                                $query->orWhereHas('buildings', function ($q) use ($value) {
                                    $q->whereHas('build', function ($qq) use ($value) {
                                        $qq->where('nama_bangunan', 'like', '%' . $value . '%');
                                    });
                                });
                            } elseif ($column == 'nama_irigasi') {
                                $query->orWhereHas('segments', function ($q) use ($value) {
                                    $q->whereHas('segmen', function ($qq) use ($value) {
                                        $qq->where('name', 'like', '%' . $value . '%');
                                    });
                                });
                            } elseif ($column == 'no_ticket') {
                                $query->orWhere('no_ticket', 'like', '%' . $value . '%');
                            } elseif (strpos($value, '/') !== false && preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $value)) {
                                $dateParts = explode('/', $value);
                                $formattedDate = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];
                                $query->orWhereDate('created_at', '=', $formattedDate);
                            } elseif (preg_match('/^\d{4}$/', $value)) {
                                $query->orWhereYear('created_at', '=', $value);
                            }
                        }
                    });
                }
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
            $report = ReportList::findOrFail($id);
            $report->delete();

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

    public function reportexportbuilding()
    {
        return Excel::download(new ReportBangunanExport, 'recap_pelaporan-saluran-irigasi.xlsx');
    }

    public function reportexportirrigation()
    {
        return Excel::download(new ReportIrrigationExport, 'recap_pelaporan-bangunan-irigasi.xlsx');
    }
}
