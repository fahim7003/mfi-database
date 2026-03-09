<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mfi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mfis';

    protected $fillable = [
        'sl_no',
        'license_number_of_mfi',
        'licence_no',
        'name_of_mfi',
        'name_without_abbreviation',
        'sort_name',
        't_50',
        'cdf',
        't_100',
        'pksf',
        'current_address',
        'phone',
        'email',
        'no_of_branches',
        'number_of_employees_total',
        'number_of_clients_total',
        'number_of_borrowers_total',
        'savings_bdt',
        'loan_disbursement_bdt',
        'loan_outstanding_bdt',
        'division',
        'district',
        'dhaka_area',
    ];

    protected $casts = [
        'sl_no' => 'integer',
        'no_of_branches' => 'integer',
        'number_of_employees_total' => 'integer',
        'number_of_clients_total' => 'integer',
        'number_of_borrowers_total' => 'integer',
        'savings_bdt' => 'decimal:2',
        'loan_disbursement_bdt' => 'decimal:2',
        'loan_outstanding_bdt' => 'decimal:2',
    ];

    public static function getColumnLabels(): array
    {
        return [
            'sl_no' => 'SL No.',
            'license_number_of_mfi' => 'License Number of MFI',
            'licence_no' => 'Licence No.',
            'name_of_mfi' => 'Name of MFI',
            'name_without_abbreviation' => 'Name (without abbreviation)',
            'sort_name' => 'Sort Name',
            't_50' => 'T-50',
            'cdf' => 'CDF',
            't_100' => 'T-100',
            'pksf' => 'PKSF',
            'current_address' => 'Current Address',
            'phone' => 'Phone',
            'email' => 'Email',
            'no_of_branches' => 'No. of Branches',
            'number_of_employees_total' => 'Number of Employees Total',
            'number_of_clients_total' => 'Number of Clients Total',
            'number_of_borrowers_total' => 'Number of Borrowers Total',
            'savings_bdt' => 'Savings (BDT)',
            'loan_disbursement_bdt' => 'Loan Disbursement (BDT)',
            'loan_outstanding_bdt' => 'Loan Outstanding (BDT)',
            'division' => 'Division',
            'district' => 'District',
            'dhaka_area' => 'Dhaka Area',
        ];
    }

    public static function getFilterableColumns(): array
    {
        return array_keys(self::getColumnLabels());
    }
}