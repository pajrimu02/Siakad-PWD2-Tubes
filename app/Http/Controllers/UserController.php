<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserImport;
use App\Exports\UserExport;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['roles', 'mahasiswa']);

        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // FILTER ROLE
        if ($request->role) {
            $query->role($request->role);
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,mahasiswa',
        ]);

        DB::beginTransaction();

        try {

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // assign role
            $user->assignRole($request->role);

            DB::commit();

            return redirect()
                ->route('users.index')
                ->with('success', 'User berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal tambah user: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $user = User::with(['roles', 'mahasiswa', 'dosen'])->findOrFail($id);

        return view('admin.users.detail', compact('user'));
    }

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'role'  => 'required|in:admin,mahasiswa',
        ]);

        DB::beginTransaction();

        try {

            $data = [
                'name'  => $request->name,
                'email' => $request->email,
            ];

            if ($request->password) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            // sync role
            $user->syncRoles([$request->role]);

            DB::commit();

            return redirect()
                ->route('users.index')
                ->with('success', 'User berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal update user: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        DB::beginTransaction();

        try {
            $user->syncRoles([]);
            $user->delete();

            DB::commit();

            return back()->with('success', 'User berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal hapus user: ' . $e->getMessage());
        }
    }

    // =========================
    // EXPORT EXCEL
    // =========================
    public function exportExcel()
    {
        return Excel::download(new UserExport, 'users.xlsx');
    }

    // =========================
    // IMPORT EXCEL
    // =========================
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new UserImport, $request->file('file'));

            return back()->with('success', 'Import user berhasil');

        } catch (\Exception $e) {
            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }
}