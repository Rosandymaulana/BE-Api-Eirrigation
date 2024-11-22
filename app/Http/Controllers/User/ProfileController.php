<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\File;
use App\FirebaseStorage;
use App\Models\File\UploadDump;

class ProfileController extends Controller
{
    function show_profile() {
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();
        return response()->json($user);
    }
    function edit_profile(Request $request) {
        try{
            $user_id = auth()->user()->id;
            $user = User::where('id', $user_id)->first();
            $validatedData = $request->validate([
                'fullname' => 'required|string|max:100',
            ]);
            $fullname = $request->fullname;
            $image = $request->image;
            $user_ip = $request->ip();
            function uploadImage($image, $user_ip) {
                $parts = explode(';', $image);
                $mimePart = explode(':', $parts[0]);
                $mime = end($mimePart);
                $imageExtension = explode('/', $mime)[1];
                if($imageExtension=="php"){
                    return null;
                }
                $image = preg_replace('#^data:image/\w+;base64,#i', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = uniqid().'.'.$imageExtension;
                $imagePath = public_path('images'). '/' . $imageName;
                $image = base64_decode($image);
                File::put($imagePath, $image);
                $storage = FirebaseStorage::initialize();
                $bucket = $storage->bucket('irrigation-upload-dump.appspot.com');
        
                $bucket->upload(fopen($imagePath, 'r'), [
                    'name' => 'image/' . $imageName,
                    'predefinedAcl' => 'publicRead'
                ]);
                $file_url = 'https://storage.googleapis.com/irrigation-upload-dump.appspot.com/image/' . $imageName;
                $uploadDump = UploadDump::create([
                    'filename' => $imageName,
                    'file_type' => File::extension($imagePath),
                    'size' => File::size($imagePath),
                    'folder' => 'image',
                    'file_url' => $file_url,
                    'uploader_ip' => $user_ip,
                    'uploader_status' => true,
                ]);
                File::delete($imagePath);
                return $file_url;
            }
            $user->fullname = $fullname;
            if($image!=null){
                $user->avatar = uploadImage($image, $user_ip);
            }
            $user->save();
            return response()->json(["message"=>"The user data has been updated"]);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update your profile',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
