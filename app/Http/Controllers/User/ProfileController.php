<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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
                'fullname' => 'sometimes|string|max:100',
                'shortname' => 'sometimes|string|max:100',
                'phone' => 'sometimes|string|max:13'
            ]);
            $update_user = $user->update($validatedData);
            return response()->json(["user"=>$update_user]);
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
