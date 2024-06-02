<?php

namespace App\Http\Controllers\UploadDump;

use App\Http\Controllers\Controller;
use App\Http\Resources\File\PhotoIrrigationBuildingResource;
use App\Models\File\PhotoIrrigationBuilding;
use App\Models\Map\BangunanIrigasi;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class PhotoIrrigationsBuildingController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'building_id' => 'required',
                'upload_dump_id' => 'required',
                'filename' => 'required',
                'file_url' => 'required',
            ]);

            $photo_repair = BangunanIrigasi::findOrFail($validatedData['building_id']);

            $photo_repair = PhotoIrrigationBuilding::create($validatedData);

            return response()->json([
                'message' => 'PhotoIrrigationBuilding created successfully',
                'data' => new PhotoIrrigationBuildingResource(($photo_repair)),
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'IrrigationBuilding not found with provided ID',
                'message' => $e->getMessage(),
            ], 404);
        } catch (ValidationException $err) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $err->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update PhotoIrrigationBuilding',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $role = PhotoIrrigationBuilding::findOrFail($id);
            $role->delete();

            return response()->json([
                'message' => 'PhotoIrrigationBuilding deleted successfully',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'PhotoIrrigationBuilding not found with provided ID',
                'message' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete PhotoIrrigationBuilding',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
