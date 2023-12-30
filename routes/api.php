<?php

use App\Http\Controllers\API\ApiAuthController;
use App\Http\Controllers\API\DataUserController;
use App\Http\Controllers\API\MasterLokasiController;
use App\Http\Controllers\API\MasterShiftController;
use App\Http\Controllers\API\TransaksiShiftController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('v1/get-master-shift',[MasterShiftController::class, 'data_master_shift']);
Route::get('v1/get-master-lokasi',[MasterLokasiController::class, 'data_master_lokasi']);
Route::get('v1/get-transaksi-shift/{employeeID}',[TransaksiShiftController::class, 'data_transaksi_shift']);
Route::post('v1/proses-login',[ApiAuthController::class, 'login']);
Route::get('v1/get-data-user/{employeeID}',[DataUserController::class, 'data_user']);