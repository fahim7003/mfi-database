<?php

namespace Database\Seeders;

use App\Models\Mfi;
use Illuminate\Database\Seeder;

class MfiSeeder extends Seeder
{
    public function run(): void
    {
        // Path to CSV file in storage/app folder
        $filePath = storage_path('app/mfi_data.csv');

        if (!file_exists($filePath)) {
            $this->command->error('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->command->error('CSV FILE NOT FOUND!');
            $this->command->error('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->command->warn('Please place your CSV file at:');
            $this->command->info($filePath);
            $this->command->newLine();
            $this->command->warn('The CSV should have these column headers:');
            $this->command->info('SL No., License Number of MFI, Licence No., Name of MFI, etc.');
            $this->command->newLine();
            $this->command->info('Creating sample data for testing...');
            $this->createSampleData();
            return;
        }

        $this->importFromCsv($filePath);
    }

    private function importFromCsv(string $filePath): void
    {
        $file = fopen($filePath, 'r');
       
        // Read header row
        $headers = fgetcsv($file);
       
        // Clean headers (remove BOM and trim)
        $headers = array_map(function($header) {
            return trim(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $header));
        }, $headers);

        // Column mapping from CSV headers to database columns
        $columnMapping = [
            'SL No.' => 'sl_no',
            'SL No' => 'sl_no',
            'License Number of MFI' => 'license_number_of_mfi',
            'Licence No.' => 'licence_no',
            'Licence No' => 'licence_no',
            'Name of MFI' => 'name_of_mfi',
            'Name (without abbreviation)' => 'name_without_abbreviation',
            'Sort Name' => 'sort_name',
            'T- 50' => 't_50',
            'T-50' => 't_50',
            'CDF' => 'cdf',
            'T-100' => 't_100',
            'T- 100' => 't_100',
            'PKSF' => 'pksf',
            'Current Address' => 'current_address',
            'Phone' => 'phone',
            'Email' => 'email',
            'No. of Branches' => 'no_of_branches',
            'No of Branches' => 'no_of_branches',
            'Number of Employees Total' => 'number_of_employees_total',
            'Number of Clients Total' => 'number_of_clients_total',
            'Number of Borrowers Total' => 'number_of_borrowers_total',
            'Savings (BDT)' => 'savings_bdt',
            'Savings BDT' => 'savings_bdt',
            'Loan Disbursement (BDT)' => 'loan_disbursement_bdt',
            'Loan Disbursement BDT' => 'loan_disbursement_bdt',
            'Loan Outstanding (BDT)' => 'loan_outstanding_bdt',
            'Loan Outstanding BDT' => 'loan_outstanding_bdt',
            'Division' => 'division',
            'District' => 'district',
            'Dhaka Area' => 'dhaka_area',
        ];

        // Map header indices to database columns
        $headerMap = [];
        foreach ($headers as $index => $header) {
            if (isset($columnMapping[$header])) {
                $headerMap[$index] = $columnMapping[$header];
            }
        }

        $rowCount = 0;
        while (($row = fgetcsv($file)) !== false) {
            $data = [];
            foreach ($headerMap as $index => $dbColumn) {
                if (isset($row[$index])) {
                    $value = trim($row[$index]);
                   
                    // Clean numeric values
                    if (in_array($dbColumn, ['savings_bdt', 'loan_disbursement_bdt', 'loan_outstanding_bdt'])) {
                        $value = preg_replace('/[^0-9.]/', '', $value);
                        $value = $value !== '' ? (float)$value : null;
                    } elseif (in_array($dbColumn, ['sl_no', 'no_of_branches', 'number_of_employees_total', 'number_of_clients_total', 'number_of_borrowers_total'])) {
                        $value = preg_replace('/[^0-9]/', '', $value);
                        $value = $value !== '' ? (int)$value : null;
                    } else {
                        $value = $value !== '' ? $value : null;
                    }
                   
                    $data[$dbColumn] = $value;
                }
            }

            if (!empty(array_filter($data))) {
                Mfi::create($data);
                $rowCount++;
            }
        }

        fclose($file);
        $this->command->info("Successfully imported {$rowCount} MFI records from CSV.");
    }

    private function createSampleData(): void
    {
        $divisions = ['Dhaka', 'Chittagong', 'Rajshahi', 'Khulna', 'Sylhet', 'Barisal', 'Rangpur', 'Mymensingh'];
        $districts = ['Dhaka', 'Gazipur', 'Narayanganj', 'Chittagong', 'Comilla', 'Rajshahi', 'Khulna', 'Sylhet'];

        for ($i = 1; $i <= 25; $i++) {
            Mfi::create([
                'sl_no' => $i,
                'license_number_of_mfi' => 'MFI-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'licence_no' => 'LIC-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'name_of_mfi' => 'Sample MFI Organization ' . $i,
                'name_without_abbreviation' => 'Sample Microfinance Institution Organization Number ' . $i,
                'sort_name' => 'SMFI' . $i,
                't_50' => rand(0, 1) ? 'Yes' : 'No',
                'cdf' => rand(0, 1) ? 'Yes' : 'No',
                't_100' => rand(0, 1) ? 'Yes' : 'No',
                'pksf' => rand(0, 1) ? 'Yes' : 'No',
                'current_address' => 'Sample Address ' . $i . ', Block ' . chr(64 + rand(1, 26)) . ', City Area',
                'phone' => '01' . rand(3, 9) . str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT),
                'email' => 'contact' . $i . '@samplemfi.org',
                'no_of_branches' => rand(5, 100),
                'number_of_employees_total' => rand(50, 5000),
                'number_of_clients_total' => rand(1000, 100000),
                'number_of_borrowers_total' => rand(500, 80000),
                'savings_bdt' => rand(1000000, 999999999) / 100,
                'loan_disbursement_bdt' => rand(10000000, 9999999999) / 100,
                'loan_outstanding_bdt' => rand(5000000, 4999999999) / 100,
                'division' => $divisions[array_rand($divisions)],
                'district' => $districts[array_rand($districts)],
                'dhaka_area' => rand(0, 1) ? 'Yes' : 'No',
            ]);
        }

        $this->command->info('Created 25 sample MFI records for testing.');
    }
}