<?php

namespace App\Imports;

use App\Models\MataKuliah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class MataKuliahImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors;

    /**
     * Kolom Excel: kode_mk | nama_mk | sks | semester
     */
    public function model(array $row)
    {
        if (MataKuliah::where('kode_mk', $row['kode_mk'])->exists()) {
            return null; // skip duplikat
        }

        return new MataKuliah([
            'kode_mk'  => $row['kode_mk'],
            'nama_mk'  => $row['nama_mk'],
            'sks'      => $row['sks'],
            'semester' => $row['semester'],
        ]);
    }

    public function rules(): array
    {
        return [
            'kode_mk'  => 'required',
            'nama_mk'  => 'required',
            'sks'      => 'required|integer|min:1|max:6',
            'semester' => 'required|integer|min:1|max:8',
        ];
    }
}