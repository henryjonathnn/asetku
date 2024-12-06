<?php

use App\Http\Controllers\AsetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\MasterController;
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


// ASET
Route::middleware('auth')->group(function () {
    Route::get('aset', [AsetController::class, 'index'])->name('aset.index');
    Route::get('aset/{uuid}/edit', [AsetController::class, 'edit'])->name('aset.edit');
    Route::post('aset', [AsetController::class, 'store'])->name('aset.store');
    Route::put('aset/{uuid}', [AsetController::class, 'update'])->name('aset.update');
    Route::delete('aset/{uuid}', [AsetController::class, 'destroy'])->name('aset.destroy');
    Route::get('aset/datatables', [AsetController::class, 'datatables'])->name('aset.datatables');

    Route::get('/', function () {
        return redirect('/aset');
    });

    // BARCODE
    Route::get('aset/{uuid}/detail', [AsetController::class, 'detail']);
    Route::post('/aset/print-multiple', [BarcodeController::class, 'printBulkQRCodes'])->name('barcode.print-multiple');

    // PROFILE / SETTINGS
    Route::get('/settings', [AuthController::class, 'settings'])->name('settings');
    Route::put('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/users/create', [AuthController::class, 'createUser'])->name('users.create');
    Route::put('/users/{user}/update', [AuthController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}/delete', [AuthController::class, 'deleteUser'])->name('users.delete');

    // MASTER
    Route::resource('master', MasterController::class);
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
Route::get('/aset/datatables', [AsetController::class, 'datatables'])->name('aset.datatables');
