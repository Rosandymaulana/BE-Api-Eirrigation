<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Models\UserRole;
use App\Services\User\UserSectionFilter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $userFilter = new UserSectionFilter();
        $queryItems = $userFilter->transform($request);

        $query = QueryBuilder::for(User::class)
            ->allowedSorts(['username', 'email', 'fullname', 'phone', 'created_at', 'updated_at']);

        foreach ($queryItems as $filter) {
            $query->where($filter[0], $filter[1], $filter[2]);
        }

        if ($request->has('limit')) {
            $users = $query->paginate($request->query('limit'));
        } else {
            $users = $query->paginate();
        }

        $users->getCollection()->transform(function ($user) {
            return $user;
        });

        return UserResource::collection($users);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'urole_id' => 'required',
                'username' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'shortname' => 'sometimes',
                'fullname' => 'required',
                'phone' => 'required',
                'avatar' => 'sometimes'
            ]);

            $hashedPassword = Hash::make($validatedData['password']);
            $validatedData['password'] = $hashedPassword;

            $roleExists = UserRole::where('id', $validatedData['urole_id'])->exists();
            if (!$roleExists) {
                return response()->json([
                    'error' => 'Validation failed',
                    'message' => 'Invalid role ID',
                ], 422);
            }

            $user = User::create($validatedData);
            var_dump($user);

            return response()->json([
                'message' => 'User created successfully',
                'data' => new UserResource(($user)),
            ], 201);
        } catch (ValidationException $err) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $err->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to create user',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $roleId = User::findOrFail($id);

        return new UserResource($roleId);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validatedData = $request->validate([
                'username' => 'string|sometimes|max:100',
                'urole_id' => 'required',
                'email' => 'sometimes|email',
                'password' => 'sometimes',
                'fullname' => 'sometimes',
                'avatar' => 'sometimes',
                'phone' => 'sometimes',
            ]);

            $roleExists = UserRole::where('id', $validatedData['urole_id'])->exists();
            if (!$roleExists) {
                return response()->json([
                    'error' => 'Validation failed',
                    'message' => 'Invalid role ID',
                ], 422);
            }

            $user->update($validatedData);

            return response()->json([
                'message' => 'User updated successfully',
                'data' => new UserResource($user),
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found',
                'message' => $e->getMessage(),
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update user',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $role = User::findOrFail($id);
            $role->delete();

            return response()->json([
                'message' => 'User deleted successfully',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found with provided ID',
                'message' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete User',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function change_password(Request $request, $id)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8',
        ]);

        $user = User::findOrFail($id);

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['error' => 'Password lama tidak cocok'], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password berhasil diubah'], 200);
    }
}
