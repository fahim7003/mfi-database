<?php

namespace App\Http\Controllers;

use App\Models\Mfi;
use App\Exports\MfiExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportExcel(Request $request)
    {
        $query = $this->getFilteredQuery($request);
        return Excel::download(new MfiExport($query), 'mfi_data_' . date('Y-m-d_His') . '.xlsx');
    }

    public function exportCsv(Request $request)
    {
        $query = $this->getFilteredQuery($request);
        return Excel::download(new MfiExport($query), 'mfi_data_' . date('Y-m-d_His') . '.csv');
    }

    public function exportPdf(Request $request)
    {
        $query = $this->getFilteredQuery($request);
        $mfis = $query->get();
        $columnLabels = Mfi::getColumnLabels();

        $pdf = Pdf::loadView('exports.pdf', compact('mfis', 'columnLabels'))
            ->setPaper('a2', 'landscape')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
            ]);

        return $pdf->download('mfi_data_' . date('Y-m-d_His') . '.pdf');
    }

    private function getFilteredQuery(Request $request)
    {
        $query = Mfi::query();

        // Apply global search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $columns = Mfi::getFilterableColumns();
                foreach ($columns as $column) {
                    $q->orWhere($column, 'LIKE', "%{$search}%");
                }
            });
        }

        // Apply column filters
        $columns = Mfi::getFilterableColumns();
        foreach ($columns as $column) {
            if ($request->filled("filter_{$column}")) {
                $query->where($column, 'LIKE', "%{$request->input("filter_{$column}")}%");
            }
        }

        // Apply sorting
        $sortColumn = $request->get('sort', 'sl_no');
        $sortDirection = $request->get('direction', 'asc');
       
        if (in_array($sortColumn, $columns)) {
            $query->orderBy($sortColumn, $sortDirection);
        }

        return $query;
    }
}