<?php

use Illuminate\Support\Facades\Route;
// Admin Controllers 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KrsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NilaiadminController;
// User Controllers
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\KrsController as UserKrsController;
use App\Http\Controllers\User\JadwalController as UserJadwalController;
use App\Http\Controllers\User\ProfilController as UserProfilController;
use App\Http\Controllers\User\NilaiController as UserNilaiController;
use App\Http\Controllers\User\PembayaranController;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Login Redirect
|--------------------------------------------------------------------------
*/
 
 Route::get('/', function () {

    if (!auth()->check()) {
        return redirect('/login');
    }

    if (auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if (auth()->user()->hasRole('mahasiswa')) {
        return redirect()->route('user.dashboard');
    }

    return redirect('/login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('profil',        [ProfileController::class, 'index'])->name('profil.index');
    Route::get('profil/edit',   [ProfileController::class, 'edit'])->name('profil.edit');
    Route::put('profil/update', [ProfileController::class, 'update'])->name('profil.update');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->name('admin.dashboard');
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('dosen', DosenController::class);
    Route::resource('matakuliah', MatakuliahController::class);
    Route::resource('jadwal', JadwalController::class);
    Route::resource('nilai', NilaiadminController::class);
    Route::resource('krs', KrsController::class)->parameters(['krs' => 'krs']);
    Route::resource('users', UserController::class);

});

/*
|--------------------------------------------------------------------------
| USER ROUTES (MAHASISWA)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:mahasiswa'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/dashboard', [UserDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/krs', [UserKrsController::class, 'index'])
            ->name('krs.index');

        Route::get('/krs/cetak', [UserKrsController::class, 'cetak'])
        ->name('krs.cetak');

        Route::get('/jadwal', [UserJadwalController::class, 'index'])
            ->name('jadwal.index');

        Route::get('/nilai', [UserNilaiController::class, 'index'])
            ->name('nilai.index');

        Route::get('/profil', [UserProfilController::class, 'index'])
            ->name('profil.index');

        Route::get('/profil/edit', [UserProfilController::class, 'edit'])
        ->name('profil.edit');

        Route::put('/profil', [UserProfilController::class, 'update'])
        ->name('profil.update');

        Route::get('/pembayaran', [PembayaranController::class, 'index'])
            ->name('pembayaran.index');

    });

require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| Export Routes
|--------------------------------------------------------------------------
*/

Route::get('mahasiswa/export/excel',[MahasiswaController::class, 'exportExcel'])
     ->name('mahasiswa.export.excel');

Route::get('dosen/export/excel',  [DosenController::class, 'exportExcel'])->name('dosen.export.excel');

Route::get('matakuliah/export/excel',  [MataKuliahController::class, 'exportExcel'])->name('matakuliah.export.excel');

Route::get('jadwal/export/excel',  [JadwalController::class, 'exportExcel'])->name('jadwal.export.excel');

Route::get('krs-export',  [KrsController::class, 'export'])->name('krs.export');

Route::get('nilai-export',  [NilaiadminController::class, 'export'])->name('nilai.export');

Route::get('/export/excel', [UserController::class, 'exportExcel'])->name('users.export.excel');
    
/*
|--------------------------------------------------------------------------
| Import Routes
|--------------------------------------------------------------------------
*/
Route::post('mahasiswa/import/excel',[MahasiswaController::class, 'importExcel'])
     ->name('mahasiswa.import.excel');

Route::post('dosen/import/excel', [DosenController::class, 'importExcel'])->name('dosen.import.excel');

Route::post('matakuliah/import/excel', [MataKuliahController::class, 'importExcel'])->name('matakuliah.import.excel');

Route::post('jadwal/import/excel', [JadwalController::class, 'importExcel'])->name('jadwal.import.excel');

Route::post('krs-import', [KrsController::class, 'import'])->name('krs.import');

Route::post('nilai-import', [NilaiadminController::class, 'import'])->name('nilai.import');

Route::post('users/import', [UserController::class, 'importExcel'])->name('users.import.excel');