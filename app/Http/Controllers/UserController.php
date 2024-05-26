<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    function register(Request $request) {
        $username = $request->username;
        $email = $request->email;
        $password = $request->password;
        $fullname = $request->fullname;
        $shortname = $request->shortname;
        $phone = $request->phone;

        DB::table('user.users')->insert([
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'fullname' => $fullname,
            'shortname' => $shortname,
            'phone' => $phone
        ]);
    }

    function login() {
        
    }
}
