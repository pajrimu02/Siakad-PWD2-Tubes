<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class MahasiswaImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    /**
     * Format heading Excel (baris pertama):
     * nim | nama | jk | angkatan | no_hp | alamat
     */
    public function model(array $row)
    {
        // Ambil nilai & bersihkan whitespace
        $nim      = trim($row['nim']      ?? '');
        $nama     = trim($row['nama']     ?? '');
        $jk       = strtoupper(trim($row['jk'] ?? $row['jenis_kelamin'] ?? ''));
        $angkatan = trim($row['angkatan'] ?? '');
        $no_hp    = trim($row['no_hp']    ?? $row['nohp'] ?? $row['no_hp_'] ?? '');
        $alamat   = trim($row['alamat']   ?? '');

        // Skip baris kosong atau data tidak lengkap
        if (!$nim || !$nama || !$angkatan) {
            return null;
        }

        // Normalisasi JK — terima berbagai format
        if (in_array($jk, ['LAKI-LAKI', 'LAKI', 'L', 'MALE', 'M'])) {
            $jk = 'L';
        } elseif (in_array($jk, ['PEREMPUAN', 'WANITA', 'P', 'FEMALE', 'F'])) {
            $jk = 'P';
        } else {
            $jk = 'L'; // default jika tidak dikenali
        }

        // Skip jika NIM sudah ada
        if (Mahasiswa::where('nim', $nim)->exists()) {
            return null;
        }

        return DB::transaction(function () use ($nim, $nama, $jk, $angkatan, $no_hp, $alamat) {
            $user = User::create([
                'name'     => $nama,
                'email'    => $nim . '@mahasiswa.ac.id',
                'password' => Hash::make($nim),
            ]);

            $user->assignRole('mahasiswa');

            return new Mahasiswa([
                'user_id'  => $user->id,
                'nim'      => $nim,
                'nama'     => $nama,
                'jk'       => $jk,
                'angkatan' => $angkatan,
                'no_hp'    => $no_hp  ?: null,
                'alamat'   => $alamat ?: null,
            ]);
        });
    }
}