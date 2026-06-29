<?php

namespace App\Imports;

use App\Models\MataKuliah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class MataKuliahImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    /**
     * Heading Excel baris pertama (bebas huruf kapital/spasi):
     * kode_mk | nama_mk | sks | semester
     */
    public function model(array $row)
    {
        $kode_mk  = trim($row['kode_mk']  ?? $row['kode'] ?? '');
        $nama_mk  = trim($row['nama_mk']  ?? $row['nama'] ?? '');
        $sks      = (int) ($row['sks']      ?? 0);
        $semester = (int) ($row['semester'] ?? 0);

        // Skip baris kosong
        if (!$kode_mk || !$nama_mk || !$sks || !$semester) {
            return null;
        }

        // Skip duplikat kode MK
        if (MataKuliah::where('kode_mk', $kode_mk)->exists()) {
            return null;
        }

        return new MataKuliah([
            'kode_mk'  => $kode_mk,
            'nama_mk'  => $nama_mk,
            'sks'      => $sks,
            'semester' => $semester,
        ]);
    }
}