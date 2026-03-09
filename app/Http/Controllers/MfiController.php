<?php

namespace App\Http\Controllers;

use App\Models\Mfi;
use Illuminate\Http\Request;

class MfiController extends Controller
{
    public function index(Request $request)
    {
        $query = Mfi::query();

        // Global Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $columns = Mfi::getFilterableColumns();
                foreach ($columns as $column) {
                    $q->orWhere($column, 'LIKE', "%{$search}%");
                }
            });
        }

        // Column-specific filters
        $columns = Mfi::getFilterableColumns();
        $booleanColumns = ['t_50', 'cdf', 't_100', 'pksf'];

        foreach ($columns as $column) {

            if ($column === 'division' && $request->filled('filter_division')) {
                $divisions = $request->input('filter_division');
                if (is_array($divisions)) {
                    $query->whereIn('division', $divisions);
                } else {
                    $query->where('division', $divisions);
                }
            } elseif ($column === 'district' && $request->filled('filter_district')) {
                $districts = $request->input('filter_district');
                if (is_array($districts)) {
                    $query->whereIn('district', $districts);
                } else {
                    $query->where('district', $districts);
                }
            } elseif ($request->filled("filter_{$column}")) {
                $query->where($column, 'LIKE', "%{$request->input("filter_{$column}")}%");
            }

            if (!$request->filled("filter_{$column}")) {
                continue;
            }

            $value = $request->input("filter_{$column}");

            // Special logic for Yes/No filters
            if (in_array($column, $booleanColumns)) {

                if ($value === 'Yes') {
                    $query->whereNotNull($column)
                        ->where($column, '!=', '');
                }

                if ($value === 'No') {
                    $query->where(function ($q) use ($column) {
                        $q->whereNull($column)
                        ->orWhere($column, '');
                    });
                }

            } else {

                // Normal filtering
                $query->where($column, 'LIKE', "%{$value}%");

            }
        }

        // Sorting
        $sortColumn = $request->get('sort', 'sl_no');
        $sortDirection = $request->get('direction', 'asc');

        $numericColumns = [
            'sl_no',
            'licence_no',
            't_50',
            't_100',
            'cdf',
            'pksf',
            'no_of_branches',
            'number_of_employees_total',
            'number_of_clients_total',
            'number_of_borrowers_total',
            'savings_bdt',
            'loan_disbursement_bdt',
            'loan_outstanding_bdt'
        ];

        if (in_array($sortColumn, $columns)) {

            if (in_array($sortColumn, $numericColumns)) {
                $query->orderByRaw("CAST($sortColumn AS UNSIGNED) $sortDirection");
            } else {
                $query->orderBy($sortColumn, $sortDirection);
            }

        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $mfis = $query->paginate($perPage)->withQueryString();

        $columnLabels = Mfi::getColumnLabels();

        // Get unique values for filter dropdowns
        $filterOptions = [];
        foreach (['division', 'district', 'dhaka_area'] as $col) {
            $filterOptions[$col] = Mfi::select($col)
                ->distinct()
                ->whereNotNull($col)
                ->orderBy($col)
                ->pluck($col)
                ->toArray();
        }

        return view('mfi.index', compact('mfis', 'columnLabels', 'sortColumn', 'sortDirection', 'filterOptions'));
    }

    public function show(Mfi $mfi)
    {
        $columnLabels = Mfi::getColumnLabels();
        return view('mfi.show', compact('mfi', 'columnLabels'));
    }

    public function edit(Mfi $mfi)
    {
        $columnLabels = Mfi::getColumnLabels();
        return view('mfi.edit', compact('mfi', 'columnLabels'));
    }

    public function update(Request $request, Mfi $mfi)
    {
        $validated = $request->validate([
            'sl_no' => 'nullable|integer',
            'license_number_of_mfi' => 'nullable|string|max:255',
            'licence_no' => 'nullable|string|max:255',
            'name_of_mfi' => 'nullable|string|max:255',
            'name_without_abbreviation' => 'nullable|string',
            'sort_name' => 'nullable|string|max:255',
            't_50' => 'nullable|string|max:50',
            'cdf' => 'nullable|string|max:50',
            't_100' => 'nullable|string|max:50',
            'pksf' => 'nullable|string|max:50',
            'current_address' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'no_of_branches' => 'nullable|integer',
            'number_of_employees_total' => 'nullable|integer',
            'number_of_clients_total' => 'nullable|integer',
            'number_of_borrowers_total' => 'nullable|integer',
            'savings_bdt' => 'nullable|numeric',
            'loan_disbursement_bdt' => 'nullable|numeric',
            'loan_outstanding_bdt' => 'nullable|numeric',
            'division' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'dhaka_area' => 'nullable|string|max:50',
        ]);

        $mfi->update($validated);

        return redirect()->route('mfi.index')
            ->with('success', 'MFI record updated successfully.');
    }

    public function destroy(Mfi $mfi)
    {
        $mfi->delete();
        return redirect()->route('mfi.index')
            ->with('success', 'MFI record deleted successfully.');
    }

    public function restore($id)
    {
        $mfi = Mfi::withTrashed()->findOrFail($id);
        $mfi->restore();
        return redirect()->route('mfi.index')
            ->with('success', 'MFI record restored successfully.');
    }

    public function trashed()
    {
        $mfis = Mfi::onlyTrashed()->paginate(15);
        $columnLabels = Mfi::getColumnLabels();
        return view('mfi.trashed', compact('mfis', 'columnLabels'));
    }
}