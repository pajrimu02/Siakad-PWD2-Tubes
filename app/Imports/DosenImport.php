<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class DosenImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors;

    /**
     * Kolom Excel: nidn | nama | email | no_hp | alamat
     */
    public function model(array $row)
    {
        if (Dosen::where('nidn', $row['nidn'])->exists()) {
            return null;
        }

        return DB::transaction(function () use ($row) {
            $user = User::create([
                'name'     => $row['nama'],
                'email'    => $row['email'],
                'password' => Hash::make($row['nidn']),
            ]);

            $user->assignRole('dosen');

            return new Dosen([
                'user_id' => $user->id,
                'nidn'    => $row['nidn'],
                'nama'    => $row['nama'],
                'email'   => $row['email'],
                'no_hp'   => $row['no_hp']  ?? null,
                'alamat'  => $row['alamat'] ?? null,
            ]);
        });
    }

    public function rules(): array
    {
        return [
            'nidn'  => 'required',
            'nama'  => 'required',
            'email' => 'required|email',
        ];
    }
}