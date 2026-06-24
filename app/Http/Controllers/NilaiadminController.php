<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Http\Request;

class NilaiadminController extends Controller
{
    public function index(Request $request)
{
    $search = $request->search;
    
        $nilais = Nilai::with(['mahasiswa', 'matakuliah'])->latest()->paginate(15);
        return view('admin.nilai.index', compact('nilais'));
    }

    public function create()
    {
        $mahasiswas = Mahasiswa::all();
        $matakuliahs = Matakuliah::all();

        return view('admin.nilai.create', compact('mahasiswas', 'matakuliahs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required',
            'matakuliah_id' => 'required',
            'semester' => 'required',
            'nilai' => 'required',
        ]);

        Nilai::create($request->all());

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil ditambahkan');
    }

    public function edit(Nilai $nilai)
    {
        $mahasiswas = Mahasiswa::all();
        $matakuliahs = Matakuliah::all();

        return view('admin.nilai.edit', compact('nilai', 'mahasiswas', 'matakuliahs'));
    }

    public function update(Request $request, Nilai $nilai)
    {
        $request->validate([
            'mahasiswa_id' => 'required',
            'matakuliah_id' => 'required',
            'semester' => 'required',
            'nilai' => 'required',
        ]);

        $nilai->update($request->all());

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil diupdate');
    }

    public function destroy(Nilai $nilai)
    {
        $nilai->delete();
        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil dihapus');
    }
}