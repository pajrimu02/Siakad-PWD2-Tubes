<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\Krs;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.dashboard', [
            'mahasiswa'  => Mahasiswa::with('user')->get(),
            'dosen'      => Dosen::all(),
            'matakuliah' => MataKuliah::all(),
            'krs' => Krs::with('mahasiswa')->get(),
        ]);
    }
}