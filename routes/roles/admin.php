<?php

use App\Http\Controllers\About\InfoAreaController;
use App\Http\Controllers\Content\ArticleController;
use App\Http\Controllers\Content\ArticlePhotoController;
use App\Http\Controllers\Content\ComplaintController;
use App\Http\Controllers\Map\BangunanIrigasiController;
use App\Http\Controllers\Map\DaerahIrigasiController;
use App\Http\Controllers\Map\DistrictController;
use App\Http\Controllers\Map\IrrigationListController;
use App\Http\Controllers\Map\MapSegmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Map\SubDistrictController;
use App\Http\Controllers\Recapitulation\HomeRecapController;
use App\Http\Controllers\Report\CountController;
use App\Http\Controllers\Report\ReportBuildingController;
use App\Http\Controllers\Report\ReportListController;
use App\Http\Controllers\Report\ReportPhotoRepairBuildingController;
use App\Http\Controllers\Report\ReportPhotoRepairController;
use App\Http\Controllers\Report\ReportSegmentController;
use App\Http\Controllers\Report\StatusController;
use App\Http\Controllers\Spk\CriteriaController;
use App\Http\Controllers\UploadDump\UploadDumpController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\UserController;

Route::prefix('map')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('sub-district', [SubDistrictController::class, 'index']);
    Route::get('sub-district/{id}', [SubDistrictController::class, 'show']);
    Route::get('district', [DistrictController::class, 'index']);
    Route::get('district/{id}', [DistrictController::class, 'show']);
    Route::get('irrigations', [IrrigationListController::class, 'index']);
    Route::get('irrigations/{id}', [IrrigationListController::class, 'show']);
    Route::get('daerah-irigasi', [DaerahIrigasiController::class, 'index']);
    Route::get('daerah-irigasi/{id}', [DaerahIrigasiController::class, 'show']);
    Route::get('bangunan-irigasi', [BangunanIrigasiController::class, 'index']);
    Route::get('bangunan-irigasi/{id}', [BangunanIrigasiController::class, 'show']);
    Route::put('bangunan-irigasi/{id}', [BangunanIrigasiController::class, 'update']);
    Route::get('segment', [MapSegmentController::class, 'index']);
});

Route::get('irrigations', [IrrigationListController::class, 'index'])->middleware(['api_key']);

Route::prefix('roles')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('', [RoleController::class, 'index']);
    Route::get('/{id}', [RoleController::class, 'show']);
    Route::post('', [RoleController::class, 'store']);
    Route::put('/{id}', [RoleController::class, 'update']);
    Route::delete('/{id}', [RoleController::class, 'destroy']);
    Route::delete('', [RoleController::class, 'deleteAll']);
});

Route::prefix('users')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::post('', [UserController::class, 'store']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
    Route::delete('change-password/{id}', [UserController::class, 'change_password']);
});

Route::prefix('article')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('', [ArticleController::class, 'index']);
    Route::get('/{id}', [ArticleController::class, 'show']);
    Route::post('', [ArticleController::class, 'store']);
    Route::put('/{id}', [ArticleController::class, 'update']);
    Route::delete('/{id}', [ArticleController::class, 'destroy']);
});

Route::get('users-article', [ArticleController::class, 'index'])->middleware(['api_key']);

Route::prefix('article-photo')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('', [ArticlePhotoController::class, 'index']);
    Route::get('/{id}', [ArticlePhotoController::class, 'show']);
    Route::post('', [ArticlePhotoController::class, 'store']);
    Route::put('/{id}', [ArticlePhotoController::class, 'update']);
    Route::delete('/{id}', [ArticlePhotoController::class, 'destroy']);
});

Route::prefix('complaint')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('', [ComplaintController::class, 'index']);
    Route::get('/{id}', [ComplaintController::class, 'show']);
    Route::post('', [ComplaintController::class, 'store']);
    Route::put('/{id}', [ComplaintController::class, 'update']);
    Route::delete('/{id}', [ComplaintController::class, 'destroy']);
});

Route::prefix('upload-dumps')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('', [UploadDumpController::class, 'index']);
    Route::get('/{id}', [UploadDumpController::class, 'show']);
    Route::post('', [UploadDumpController::class, 'store']);
    Route::put('/{id}', [UploadDumpController::class, 'update']);
    Route::delete('/{id}', [UploadDumpController::class, 'destroy']);
});

Route::prefix('report-list')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('', [ReportListController::class, 'index']);
    Route::get('/{id}', [ReportListController::class, 'show']);
    Route::post('', [ReportListController::class, 'store']);
    Route::put('/{id}', [ReportListController::class, 'update']);
    Route::delete('/{id}', [ReportListController::class, 'destroy']);
});

Route::prefix('report-segment')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('', [ReportSegmentController::class, 'index']);
    Route::get('/{id}', [ReportSegmentController::class, 'show']);
    Route::post('', [ReportSegmentController::class, 'store']);
    Route::put('/{id}', [ReportSegmentController::class, 'update']);
    Route::delete('/{id}', [ReportSegmentController::class, 'destroy']);
});

Route::prefix('report-building')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('', [ReportBuildingController::class, 'index']);
    Route::get('/{id}', [ReportBuildingController::class, 'show']);
    Route::post('', [ReportBuildingController::class, 'store']);
    Route::put('/{id}', [ReportBuildingController::class, 'update']);
    Route::delete('/{id}', [ReportBuildingController::class, 'destroy']);
});

Route::prefix('report-photo-repair')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('', [ReportPhotoRepairController::class, 'index']);
    Route::get('/{id}', [ReportPhotoRepairController::class, 'show']);
    Route::post('', [ReportPhotoRepairController::class, 'store']);
    Route::put('/{id}', [ReportPhotoRepairController::class, 'update']);
    Route::delete('/{id}', [ReportPhotoRepairController::class, 'destroy']);
});

Route::prefix('report-photo-repair-building')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('', [ReportPhotoRepairBuildingController::class, 'index']);
    Route::get('/{id}', [ReportPhotoRepairBuildingController::class, 'show']);
    Route::post('', [ReportPhotoRepairBuildingController::class, 'store']);
    Route::put('/{id}', [ReportPhotoRepairBuildingController::class, 'update']);
    Route::delete('/{id}', [ReportPhotoRepairBuildingController::class, 'destroy']);
});

Route::prefix('status')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('', [StatusController::class, 'index']);
    Route::get('/{id}', [StatusController::class, 'show']);
    Route::post('', [StatusController::class, 'store']);
    Route::put('/{id}', [StatusController::class, 'update']);
    Route::delete('/{id}', [StatusController::class, 'destroy']);
});

Route::prefix('count')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('', [CountController::class, 'index']);
});

Route::prefix('dss')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('', [CriteriaController::class, 'index']);
});

Route::get('recapitulation', [HomeRecapController::class, 'index'])->middleware(['api', 'auth:api']);
Route::get('info-area', [InfoAreaController::class, 'index'])->middleware(['api_key']);
