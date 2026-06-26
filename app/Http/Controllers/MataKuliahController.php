<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MataKuliahExport;
use App\Imports\MataKuliahImport;

class MataKuliahController extends Controller
{
    /**
     * Daftar MataKuliah dengan search + filter semester.
     */
    public function index(Request $request)
    {
        $matakuliahs = MataKuliah::query()
            ->when($request->search, function ($q) use ($request) {
                $q->where('nama_mk', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_mk', 'like', '%' . $request->search . '%');
            })
            ->when($request->semester, function ($q) use ($request) {
                $q->where('semester', $request->semester);
            })
            ->orderBy('semester')
            ->orderBy('nama_mk')
            ->paginate(15)
            ->withQueryString();

        return view('admin.matkul.index', compact('matakuliahs'));
    }

    public function create()
    {
        return view('admin.matkul.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mk'  => 'required|unique:mata_kuliahs,kode_mk',
            'nama_mk'  => 'required|string|max:255',
            'sks'      => 'required|integer|min:1|max:6',
            'semester' => 'required|integer|min:1|max:8',
        ]);

        MataKuliah::create($request->only('kode_mk', 'nama_mk', 'sks', 'semester'));

        return redirect()->route('matakuliah.index')
            ->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    public function show($id)
    {
        $mk = MataKuliah::with(['jadwal.dosen'])->findOrFail($id);
        return view('admin.matkul.detail', compact('mk'));
    }

    public function edit($id)
    {
        $mk = MataKuliah::findOrFail($id);
        return view('admin.matkul.edit', compact('mk'));
    }

    public function update(Request $request, $id)
    {
        $mk = MataKuliah::findOrFail($id);

        $request->validate([
            'kode_mk'  => 'required|unique:mata_kuliahs,kode_mk,' . $id,
            'nama_mk'  => 'required|string|max:255',
            'sks'      => 'required|integer|min:1|max:6',
            'semester' => 'required|integer|min:1|max:8',
        ]);

        $mk->update($request->only('kode_mk', 'nama_mk', 'sks', 'semester'));

        return redirect()->route('matakuliah.index')
            ->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        MataKuliah::findOrFail($id)->delete();

        return redirect()->route('matakuliah.index')
            ->with('success', 'Mata kuliah berhasil dihapus.');
    }

    public function exportExcel()
    {
        return Excel::download(new MataKuliahExport, 'matakuliah_' . date('Ymd_His') . '.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls|max:5120']);

        try {
            Excel::import(new MataKuliahImport, $request->file('file'));
            return redirect()->route('matakuliah.index')
                ->with('success', 'Import mata kuliah berhasil.');
        } catch (\Exception $e) {
            return redirect()->route('matakuliah.index')
                ->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }
}