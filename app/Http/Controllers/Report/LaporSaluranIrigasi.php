<?php

namespace App\Http\Controllers\Report;

use App\FirebaseStorage;
use App\Http\Controllers\Controller;
use App\Http\Resources\Report\ReportListResource;
use App\Models\File\UploadDump;
use App\Models\Map\MapSegment;
use App\Models\Report\ReportList;
use App\Models\Report\ReportPhoto;
use App\Models\Report\ReportSegment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LaporSaluranIrigasi extends Controller
{
    public function store(Request $request)
    {
        var_dump($request->all());
        try {
            // Menambah ke Report List
            $reportList = ReportList::create([
                'user_id' => $request->user_id,
                'status_id' => 'PROG',
                'no_ticket' => date('ymd') . rand(10, 99),
                'type_list' => 'irrigation',
                'note' => null,
                'created_at' => Carbon::now(),
            ]);

            $notes = $request->input('note');
            $levels = $request->input('level');
            $images = $request->file('image');

            if (is_array($notes) && is_array($levels)) {
                foreach ($notes as $index => $note) {
                    $level = $levels[$index] ?? null;

                    // Menambah ke Table Report Building
                    $reportSegment = ReportSegment::create([
                        'report_id' => $reportList->id,
                        'segment_id' => MapSegment::inRandomOrder()->first()->id,
                        'level' => $level,
                        'type' => 'RUSAK',
                        'note' => $note,
                        'created_at' => Carbon::now(),
                    ]);

                    // Menambah ke Table Upload Dumps dan Menangkap Id, filename, file_url jika terdapat image
                    if (isset($images[$index])) {
                        $file = $images[$index];
                        $request->validate([
                            "image.$index" => 'required|image|mimes:jpg,png,jpeg'
                        ]);

                        $storage = FirebaseStorage::initialize();
                        $bucket = $storage->bucket('irrigation-upload-dump.appspot.com');

                        $extension = $file->getClientOriginalExtension();
                        $filename = uniqid() . '.' . $extension;

                        $bucket->upload(fopen($file->getPathname(), 'r'), [
                            'name' => 'image/' . $filename,
                            'predefinedAcl' => 'publicRead'
                        ]);

                        $imageUrl = 'https://storage.googleapis.com/irrigation-upload-dump.appspot.com/image/' . $filename;

                        // Upload ke Table Image
                        $uploadDump = UploadDump::create([
                            'filename' => $filename,
                            'file_type' => $file->getClientOriginalExtension(),
                            'size' => $file->getSize(),
                            'folder' => 'image',
                            'file_url' => $imageUrl,
                            'uploader_ip' => $request->ip(),
                            'uploader_status' => true,
                        ]);

                        // Menambah ke Table Report Photo Building
                        ReportPhoto::create([
                            'report_segment_id' => $reportSegment->id,
                            'upload_dump_id' => $uploadDump->id,
                            'filename' => $uploadDump->filename,
                            'file_url' => $uploadDump->file_url,
                            'created_at' => Carbon::now(),
                        ]);
                    }
                }
            }

            return response()->json([
                'message' => 'Report updated successfully',
                'data' => new ReportListResource($reportList),
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
}
