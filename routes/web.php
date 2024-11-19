<?php

use App\Http\Controllers\AsetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\KegiatanController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::middleware('auth')->group(function () {
    Route::resource('aset', AsetController::class)->parameters([
        'aset' => 'uuid'
    ]);
    Route::get('aset/{uuid}/detail', [AsetController::class, 'detail']);
    Route::post('/aset/print-multiple', [BarcodeController::class, 'printBulkQRCodes'])->name('barcode.print-multiple');
});

Route::get('aset/{uuid}/barcode', [BarcodeController::class, 'generate'])->name('barcode.generate');

// Route::resource('kegiatan', KegiatanController::class);
Route::get('aset/{uuid}/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
Route::post('aset/{uuid}/kegiatan', [KegiatanController::class, 'store'])->name('kegiatan.store');
Route::put('aset/{uuid}/kegiatan/update-master', [KegiatanController::class, 'updateMaster'])->name('kegiatan.update-master');
Route::delete('aset/{uuid}/kegiatan/{kegiatan}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');

// AUTH
Route::get('/login', [AuthController::class, 'loginForm']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
