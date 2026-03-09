<?php

namespace App\Http\Controllers;

use App\Models\Mfi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_mfis' => Mfi::count(),
            'total_branches' => Mfi::sum('no_of_branches'),
            'total_employees' => Mfi::sum('number_of_employees_total'),
            'total_clients' => Mfi::sum('number_of_clients_total'),
            'total_borrowers' => Mfi::sum('number_of_borrowers_total'),
            'total_savings' => Mfi::sum('savings_bdt'),
            'total_disbursement' => Mfi::sum('loan_disbursement_bdt'),
            'total_outstanding' => Mfi::sum('loan_outstanding_bdt'),
        ];

        $divisions = Mfi::select('division')
            ->distinct()
            ->whereNotNull('division')
            ->pluck('division')
            ->toArray();

        return view('dashboard', compact('stats', 'divisions'));
    }
}