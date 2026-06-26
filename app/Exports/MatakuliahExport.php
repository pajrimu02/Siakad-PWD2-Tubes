<?php

namespace App\Exports;

use App\Models\MataKuliah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MataKuliahExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return MataKuliah::orderBy('semester')->orderBy('nama_mk')->get();
    }

    public function headings(): array
    {
        return ['No', 'Kode MK', 'Nama Mata Kuliah', 'SKS', 'Semester'];
    }

    public function map($mk): array
    {
        static $no = 0;
        $no++;
        return [$no, $mk->kode_mk, $mk->nama_mk, $mk->sks, $mk->semester];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '6366F1']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}