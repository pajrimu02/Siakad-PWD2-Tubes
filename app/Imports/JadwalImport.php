<?php

namespace App\Imports;

use App\Models\Jadwal;
use App\Models\Dosen;
use App\Models\MataKuliah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class JadwalImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    /**
     * Heading Excel baris pertama:
     * kode_mk | nidn_dosen | hari | jam_mulai | jam_selesai | kelas | ruangan
     */
    public function model(array $row)
    {
        $kode_mk    = trim($row['kode_mk']     ?? $row['kode']  ?? '');
        $nidn_dosen = trim($row['nidn_dosen']  ?? $row['nidn']  ?? '');
        $hari       = ucfirst(strtolower(trim($row['hari']        ?? '')));
        $jam_mulai  = trim($row['jam_mulai']   ?? '');
        $jam_selesai= trim($row['jam_selesai'] ?? '');
        $kelas      = strtoupper(trim($row['kelas']    ?? ''));
        $ruangan    = trim($row['ruangan']     ?? '');

        // Skip baris kosong
        if (!$kode_mk || !$nidn_dosen || !$hari || !$jam_mulai || !$jam_selesai || !$kelas || !$ruangan) {
            return null;
        }

        // Cari relasi
        $mk    = MataKuliah::where('kode_mk', $kode_mk)->first();
        $dosen = Dosen::where('nidn', $nidn_dosen)->first();

        // Skip kalau MK atau dosen tidak ditemukan
        if (!$mk || !$dosen) return null;

        return new Jadwal([
            'mata_kuliah_id' => $mk->id,
            'dosen_id'       => $dosen->id,
            'hari'           => $hari,
            'jam_mulai'      => $jam_mulai,
            'jam_selesai'    => $jam_selesai,
            'kelas'          => $kelas,
            'ruangan'        => $ruangan,
        ]);
    }
}