<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KrsController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Auth Dashboard (SATU SAJA)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('dosen', DosenController::class);
    Route::resource('matakuliah', MatakuliahController::class);
    Route::resource('jadwal', JadwalController::class);
    Route::resource('krs', KrsController::class);

});

/*
|--------------------------------------------------------------------------
| Mahasiswa Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {

    Route::get('/krs-mahasiswa', function () {
        return "KRS Mahasiswa";
    });

});

require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| Export Routes
|--------------------------------------------------------------------------
*/

Route::get(
    '/mahasiswa/export-excel',
    [MahasiswaController::class,'exportExcel']
    )->name('mahasiswa.export.excel');

Route::get(
    '/dosen/export-excel',
    [DosenController::class,'exportExcel']
    )->name('dosen.export.excel');
Route::get(
    '/matakuliah/export-excel',
    [MatakuliahController::class,'exportExcel']
    )->name('matakuliah.export.excel');

    
/*
|--------------------------------------------------------------------------
| Import Routes
|--------------------------------------------------------------------------
*/
Route::post(
    '/mahasiswa/import-excel',
    [MahasiswaController::class,'importExcel']
)->name('mahasiswa.import.excel');

Route::post(
    '/dosen/import-excel',
    [DosenController::class,'importExcel']
)->name('dosen.import.excel');

Route::post(
    '/matakuliah/import-excel',
    [MatakuliahController::class,'importExcel']
)->name('matakuliah.import.excel');