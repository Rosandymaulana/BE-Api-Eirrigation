<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Resources\Report\ReportPhotoRepairBuildingResource;
use App\Models\Report\ReportBuilding;
use App\Models\Report\ReportPhotoRepairBuilding;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class ReportPhotoRepairBuildingController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'report_building_id' => 'required',
                'upload_dump_id' => 'required',
                'filename' => 'required',
                'file_url' => 'required',
            ]);

            $photo_repair = ReportBuilding::findOrFail($validatedData['report_building_id']);

            $photo_repair = ReportPhotoRepairBuilding::create($validatedData);

            return response()->json([
                'message' => 'Photo Photo Repair created successfully',
                'data' => new ReportPhotoRepairBuildingResource(($photo_repair)),
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Photo Repair not found with provided ID',
                'message' => $e->getMessage(),
            ], 404);
        } catch (ValidationException $err) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $err->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update Photo Photo Repair',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $role = ReportPhotoRepairBuilding::findOrFail($id);
            $role->delete();

            return response()->json([
                'message' => 'ReportPhotoRepairBuilding deleted successfully',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'ReportPhotoRepairBuilding not found with provided ID',
                'message' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete ReportPhotoRepairBuilding',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
