<?php

namespace App\Exports;

use App\Models\Report\ReportList;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportBangunanExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return ReportList::with(['user', 'status', 'buildings'])
            ->where('type_list', 'building')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No Ticket',
            'Status Laporan',
            'Nama Pelapor',
            'Email',
            'No HP',
            'Nama Bangunan',
            'Tipe Saluran',
            'jarak',
            'b_saluran',
            'sempadan_kanan',
            'sempadan_kiri',
            'luas_saluran',
            'sisi_terluar_kanan',
            'sisi_terluar_kiri',
            'saluran_kanan',
            'saluran_panjang_kanan',
            'saluran_kiri',
            'saluran_panjang_kiri',
            'Tingkat Kerusakan',
            'Tipe Kerusakan',
        ];
    }

    public function map($report): array
    {
        $data = [];

        foreach ($report->buildings as $building) {
            $data[] = [
                $report->no_ticket,
                $report->status->name ?? '',
                $report->user->fullname ?? '',
                $report->user->email ?? '',
                $report->user->phone ?? '',
                $building->build->nama_bangunan ?? '',
                $building->build->tipe_saluran ?? '',
                $building->build->jarak ?? '',
                $building->build->b_saluran ?? '',
                $building->build->sempadan_kanan ?? '',
                $building->build->sempadan_kiri ?? '',
                $building->build->luas_saluran ?? '',
                $building->build->sisi_terluar_kanan ?? '',
                $building->build->sisi_terluar_kiri ?? '',
                $building->build->saluran_kanan ?? '',
                $building->build->saluran_panjang_kanan ?? '',
                $building->build->saluran_kiri ?? '',
                $building->build->saluran_panjang_kiri ?? '',
                $building->type,
                $building->level,
            ];
        }

        return $data;
    }
}
