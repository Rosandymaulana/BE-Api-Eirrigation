<?php

namespace App\Http\Controllers\UploadDump;

use App\FirebaseStorage;
use App\Http\Controllers\Controller;
use App\Http\Resources\File\UploadDumpResource;
use App\Models\File\UploadDump;
use App\Services\File\UploadDumpFilter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Spatie\QueryBuilder\QueryBuilder;

class UploadDumpController extends Controller
{
    public function index(Request $request)
    {
        $uploadDumpFilter = new UploadDumpFilter();
        $queryItems = $uploadDumpFilter->transform($request);

        $query = QueryBuilder::for(UploadDump::class)
            ->allowedSorts([
                'filename',
                'file_type',
                'size',
                'folder',
                'file_url',
                'uploader_ip',
                'uploader_status',
                'created_at',
                'updated_at',
            ]);

        foreach ($queryItems as $filter) {
            $query->where($filter[0], $filter[1], $filter[2]);
        }

        if ($request->has('limit')) {
            $uploadDump = $query->paginate($request->query('limit'));
        } else {
            $uploadDump = $query->paginate();
        }

        $uploadDump->getCollection()->transform(function ($article) {
            return $article;
        });

        return UploadDumpResource::collection($uploadDump);
    }

    public function show($id)
    {
        $uploadDumpId = UploadDump::findOrFail($id);

        return new UploadDumpResource($uploadDumpId);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpg,png,jpeg'
            ]);

            $storage = FirebaseStorage::initialize();
            $bucket = $storage->bucket('irrigation-upload-dump.appspot.com');
            $file = $request->file('image');

            $extension = $file->getClientOriginalExtension();
            $filename = uniqid() . '.' . $extension;

            $bucket->upload(fopen($file->getPathname(), 'r'), [
                'name' => 'image/' . $filename,
                'predefinedAcl' => 'publicRead'
            ]);

            $imageUrl = 'https://storage.googleapis.com/irrigation-upload-dump.appspot.com/image/' . $filename;

            $uploadDump = UploadDump::create([
                'filename' => $filename,
                'file_type' => $file->getClientOriginalExtension(),
                'size' => $file->getSize(),
                'folder' => 'image',
                'file_url' => $imageUrl,
                'uploader_ip' => $request->ip(),
                'uploader_status' => true,
            ]);

            return response()->json([
                'message' => 'File created successfully',
                'data' => new UploadDumpResource($uploadDump),
            ], 201);
        } catch (ValidationException $err) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $err->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to add file',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $uploadDump = UploadDump::findOrFail($id);

            $file = $request->file('image');

            if ($file) {
                $request->validate([
                    'image' => 'required|image|mimes:jpg,png,jpeg'
                ]);

                $storage = FirebaseStorage::initialize();
                $bucket = $storage->bucket('irrigation-upload-dump.appspot.com');

                $filenameToDelete = $uploadDump->filename;
                $object = $bucket->object('image/' . $filenameToDelete);
                if ($object->exists()) {
                    $object->delete();
                }

                $extension = $file->getClientOriginalExtension();
                $filename = uniqid() . '.' . $extension;

                $bucket->upload(fopen($file->getPathname(), 'r'), [
                    'name' => 'image/' . $filename,
                ]);

                $uploadDump->file_url =
                    'https://storage.googleapis.com/irrigation-upload-dump.appspot.com/image/' . $filename;
                $uploadDump->filename = $filename;
                $uploadDump->file_type = $file->getClientOriginalExtension();
                $uploadDump->size = $file->getSize();
            }

            if ($file) {
                $uploadDump->update([
                    'filename' => $uploadDump->filename,
                    'file_type' => $uploadDump->file_type,
                    'size' => $uploadDump->size,
                    'folder' => $uploadDump->folder,
                    'file_url' => $uploadDump->file_url,
                    'uploader_ip' => $uploadDump->uploader_ip,
                    'uploader_status' => $uploadDump->uploader_status,
                ]);
            }

            return response()->json([
                'message' => 'File updated successfully',
                'data' => new UploadDumpResource($uploadDump),
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'File not found with provided ID',
                'message' => $e->getMessage(),
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update file',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $role = UploadDump::findOrFail($id);
            $role->delete();

            return response()->json([
                'message' => 'File deleted successfully',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'File not found with provided ID',
                'message' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete File',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
