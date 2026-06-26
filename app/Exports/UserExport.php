<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Ambil data user
     */
    public function collection()
    {
        return User::with(['mahasiswa', 'dosen'])->get();
    }

    /**
     * Header Excel
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Email',
            'Role',
            'NIM (Mahasiswa)',
            'Nama Mahasiswa',
            'NIDN (Dosen)',
            'Nama Dosen',
            'Created At',
        ];
    }

    /**
     * Mapping data ke row Excel
     */
    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->getRoleNames()->implode(', '),

            $user->mahasiswa->nim ?? '-',
            $user->mahasiswa->nama ?? '-',

            $user->dosen->nidn ?? '-',
            $user->dosen->nama ?? '-',

            $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : '-',
        ];
    }
}