<?php

namespace App\Exports;

use App\Models\Report\ReportList;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportIrrigationExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return ReportList::with(['user', 'status', 'segments.segmen.irrigation'])
            ->where('type_list', 'irrigation')
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
            'Nama Irigasi',
            'Titik Kerusakan',
            'Daerah Irigasi',
            'Desa/Kel',
            'Tipe Saluran',
            'Tingkat Kerusakan',
            'Tipe Kerusakan',
            'Panjang Saluran'
        ];
    }

    public function map($report): array
    {
        $data = [];

        foreach ($report->segments as $segment) {
            $data[] = [
                $report->no_ticket,
                $report->status->name ?? '',
                $report->user->fullname ?? '',
                $report->user->email ?? '',
                $report->user->phone ?? '',
                $segment->segmen->name ?? '',
                $segment->segmen->center_point,
                $segment->segmen->sub_district_name ?? '',
                $segment->segmen->sub_district_type ?? '',
                $segment->segmen->type ?? '',
                $segment->level,
                $segment->type,
                $segment->segmen->irrigation->length ?? ''
            ];
        }

        return $data;
    }
}
