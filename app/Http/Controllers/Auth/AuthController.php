<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 400);
        }

        $user_id = auth()->user()->id;
        $customClaims = ['user' => User::where('id', $user_id)->select('id as user_id', 'email', 'username')->first()];
        $jwt = JWTAuth::claims($customClaims)->attempt($credentials);

        return $this->respondWithToken($jwt);
    }

    public function register()
    {
        $validator = Validator::make(request()->all(), [
            'urole_id' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'fullname' => 'required',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $user = User::create([
            'urole_id' => request('urole_id'),
            'username' => request('username'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
            'fullname' => request('fullname'),
            'avatar' => request('avatar'),
            'phone' => request('phone'),
            'created_at' => Carbon::now(),
        ]);

        if ($user) {
            return response()->json(['message' => 'Pendaftaran Berhasil']);
        } else {
            return response()->json(['message' => 'Pendaftaran Gagal']);
        };
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($jwt)
    {
        return response()->json([
            'data' => [
                'jwtToken' => $jwt,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ],
            'statusCode' => 200,
            'message' => 'OK'
        ]);
    }
}
