<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group([], function () {
    Route::get('/', function () {
        return response()->json([
            'message' => 'Welcome to Project Eirrigation REST API',
            'status' => 'success',
            'statusCode' => 200
        ]);
    });

    Route::get('api', function () {
        return response()->json([
            'statusCode' => 200,
            'message' => 'Please contact developer for more information'
        ]);
    });
});
