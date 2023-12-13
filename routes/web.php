<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataSecurityController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\TransaksiShiftDTController;
use App\Http\Controllers\TransaksiShiftHDController;
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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [AuthController::class, 'login_admin'])->name('login')->middleware('guest');
Route::get('/login', [AuthController::class, 'login_admin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate_admin']);
Route::get('/dashboard/logout', [AuthController::class, 'logout']);

Route::group(['middleware' => 'auth'], function() {
    Route::get('/dashboard',[DashboardController::class, 'halaman_dashboard']);
    Route::get('/get-data-dashboard', [DashboardController::class,'get_data_dashboard']);
    
    Route::get('/data-lokasi',[LokasiController::class, 'data_lokasi']);
    Route::post('/data-lokasi/add',[LokasiController::class, 'lokasi_add']);
    Route::post('/data-lokasi/edit',[LokasiController::class, 'lokasi_edit']);
    Route::delete('/data-lokasi/delete',[LokasiController::class, 'lokasi_delete']);
    Route::get('/get-data-lokasi/{id}', [LokasiController::class, 'get_data_lokasi']);

    Route::get('/master-shift',[ShiftController::class, 'data_shift']);
    Route::post('/master-shift/add',[ShiftController::class, 'shift_add']);
    Route::post('/master-shift/edit',[ShiftController::class, 'shift_edit']);
    Route::delete('/master-shift/delete',[ShiftController::class, 'shift_delete']);
    Route::get('/get-master-shift/{id}', [ShiftController::class, 'get_data_master']);
    
    Route::get('/data-security',[DataSecurityController::class, 'data_security']);
    Route::post('/data-security/add',[DataSecurityController::class, 'data_security_add']);
    Route::post('/data-security/edit',[DataSecurityController::class, 'data_security_edit']);
    Route::delete('/data-security/delete',[DataSecurityController::class, 'data_security_delete']);
    Route::get('/get-data-security/{id}', [DataSecurityController::class, 'get_data_security']);
    
    Route::get('/data-admin',[AdminController::class, 'data_admin']);
    Route::post('/data-admin/add',[AdminController::class, 'admin_add']);
    Route::post('/data-admin/edit',[AdminController::class, 'admin_edit']);
    Route::delete('/data-admin/delete',[AdminController::class, 'admin_delete']);
    Route::get('/get-data-admin/{id}',[AdminController::class, 'get_data_admin']);

    Route::get('/transaksi-shift',[TransaksiShiftHDController::class, 'data_transaksi_shift_hd']);
    Route::post('/transaksi-shift/add',[TransaksiShiftHDController::class, 'transaksi_shift_hd_add']);

    Route::get('/transaksi-shift/detail/{id}',[TransaksiShiftDTController::class, 'transaksi_shift_detail']);
    Route::post('/transaksi-shift/detail/add',[TransaksiShiftDTController::class, 'transaksi_shift_detail_add']);
});