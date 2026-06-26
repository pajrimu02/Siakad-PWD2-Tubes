<?php

namespace App\Exports;

use App\Models\Dosen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DosenExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return Dosen::with('jadwal.mataKuliah')->get();
    }

    public function headings(): array
    {
        return ['No', 'NIDN', 'Nama', 'Email', 'No. HP', 'Alamat', 'Jumlah Jadwal'];
    }

    public function map($d): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $d->nidn,
            $d->nama,
            $d->email,
            $d->no_hp  ?? '-',
            $d->alamat ?? '-',
            $d->jadwal->count(),
        ];
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