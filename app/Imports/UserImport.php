<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
{
    /**
     * Mapping setiap baris Excel ke database
     */
    public function model(array $row)
    {
        /**
         * FORMAT EXCEL (WAJIB):
         * name | email | password | role | nim | nidn
         */

        $user = User::create([
            'name'     => $row['name'],
            'email'    => $row['email'],
            'password' => Hash::make($row['password'] ?? 'password123'),
        ]);

        /**
         * Assign Role (Spatie)
         */
        if (!empty($row['role'])) {
            $user->assignRole($row['role']);
        }

        /**
         * OPTIONAL RELASI MAHASISWA
         * (kalau ada tabel mahasiswa)
         */
        if (!empty($row['nim'])) {
            $user->mahasiswa()->create([
                'nim'  => $row['nim'],
                'nama' => $row['name'],
            ]);
        }

        /**
         * OPTIONAL RELASI DOSEN
         */
        if (!empty($row['nidn'])) {
            $user->dosen()->create([
                'nidn' => $row['nidn'],
                'nama' => $row['name'],
            ]);
        }

        return $user;
    }
}