<?php

namespace App\Exports;

use App\Models\Mfi;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MfiExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return array_values(Mfi::getColumnLabels());
    }

    public function map($mfi): array
    {
        return [
            $mfi->sl_no,
            $mfi->license_number_of_mfi,
            $mfi->licence_no,
            $mfi->name_of_mfi,
            $mfi->name_without_abbreviation,
            $mfi->sort_name,
            $mfi->t_50,
            $mfi->cdf,
            $mfi->t_100,
            $mfi->pksf,
            $mfi->current_address,
            $mfi->phone,
            $mfi->email,
            $mfi->no_of_branches,
            $mfi->number_of_employees_total,
            $mfi->number_of_clients_total,
            $mfi->number_of_borrowers_total,
            $mfi->savings_bdt,
            $mfi->loan_disbursement_bdt,
            $mfi->loan_outstanding_bdt,
            $mfi->division,
            $mfi->district,
            $mfi->dhaka_area,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5']
                ]
            ],
        ];
    }
}