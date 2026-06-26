<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DosenExport;
use App\Imports\DosenImport;

class DosenController extends Controller
{
    /**
     * Daftar dosen dengan pencarian.
     */
    public function index(Request $request)
    {
        $dosens = Dosen::with('user')
            ->when($request->search, function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nidn', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.dosen.index', compact('dosens'));
    }

    /**
     * Form tambah dosen.
     */
    public function create()
    {
        return view('admin.dosen.create');
    }

    /**
     * Simpan dosen baru. User dibuat otomatis dari NIDN.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nidn'  => 'required|unique:dosens,nidn',
            'nama'  => 'required|string|max:255',
            'email' => 'required|email|unique:dosens,email',
            'no_hp' => 'nullable|string|max:20',
            'alamat'=> 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->nama,
                'email'    => $request->email,
                'password' => Hash::make($request->nidn),
            ]);

            $user->assignRole('admin');

            Dosen::create([
                'user_id' => $user->id,
                'nidn'    => $request->nidn,
                'nama'    => $request->nama,
                'email'   => $request->email,
                'no_hp'   => $request->no_hp,
                'alamat'  => $request->alamat,
            ]);
        });

        return redirect()->route('dosen.index')
            ->with('success', 'Dosen berhasil ditambahkan. Login: ' . $request->email . ' | Password: NIDN');
    }

    /**
     * Detail dosen beserta jadwal mengajar.
     */
    public function show($id)
    {
        $dosen = Dosen::with([
            'user',
            'jadwal.mataKuliah',
        ])->findOrFail($id);

        return view('admin.dosen.detail', compact('dosen'));
    }

    /**
     * Form edit dosen.
     */
    public function edit($id)
    {
        $dosen = Dosen::findOrFail($id);
        return view('admin.dosen.edit', compact('dosen'));
    }

    /**
     * Update dosen. Sinkron user terkait.
     */
    public function update(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);

        $request->validate([
            'nidn'  => 'required|unique:dosens,nidn,' . $id,
            'nama'  => 'required|string|max:255',
            'email' => 'required|email|unique:dosens,email,' . $id,
            'no_hp' => 'nullable|string|max:20',
            'alamat'=> 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $dosen) {
            if ($dosen->user) {
                $dosen->user->update([
                    'name'  => $request->nama,
                    'email' => $request->email,
                ]);
            }

            $dosen->update([
                'nidn'   => $request->nidn,
                'nama'   => $request->nama,
                'email'  => $request->email,
                'no_hp'  => $request->no_hp,
                'alamat' => $request->alamat,
            ]);
        });

        return redirect()->route('dosen.index')
            ->with('success', 'Data dosen berhasil diperbarui.');
    }

    /**
     * Hapus dosen beserta user-nya.
     */
    public function destroy($id)
    {
        $dosen = Dosen::with('user')->findOrFail($id);

        DB::transaction(function () use ($dosen) {
            if ($dosen->user) {
                $dosen->user->delete();
            }
            $dosen->delete();
        });

        return redirect()->route('dosen.index')
            ->with('success', 'Dosen berhasil dihapus.');
    }

    /**
     * Export dosen ke Excel.
     */
    public function exportExcel()
    {
        return Excel::download(new DosenExport, 'dosen_' . date('Ymd_His') . '.xlsx');
    }

    /**
     * Import dosen dari Excel.
     */
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:5120',
        ]);

        try {
            Excel::import(new DosenImport, $request->file('file'));
            return redirect()->route('dosen.index')
                ->with('success', 'Import dosen berhasil.');
        } catch (\Exception $e) {
            return redirect()->route('dosen.index')
                ->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }
}