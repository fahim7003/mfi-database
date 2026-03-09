<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>MFI Data Export - Complete Report</title>
    <style>
        @page {
            size: A2 landscape;
            margin: 10mm;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 6px;
            line-height: 1.3;
            color: #333;
        }
        .header {
            text-align: center;
            padding: 10px 0;
            border-bottom: 2px solid #4F46E5;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 16px;
            color: #4F46E5;
            margin-bottom: 3px;
        }
        .header p {
            font-size: 8px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            table-layout: fixed;
        }
        th {
            background-color: #4F46E5;
            color: white;
            padding: 4px 2px;
            text-align: left;
            font-size: 5px;
            font-weight: bold;
            border: 1px solid #3730A3;
            word-wrap: break-word;
        }
        td {
            padding: 3px 2px;
            border: 1px solid #ddd;
            font-size: 5px;
            word-wrap: break-word;
            vertical-align: top;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 7px;
            color: #666;
            padding: 5px;
            border-top: 1px solid #ddd;
            background: white;
        }
        .page-number:before {
            content: "Page " counter(page);
        }
        .summary {
            margin-top: 15px;
            padding: 8px;
            background-color: #f0f4ff;
            border: 1px solid #c7d2fe;
        }
        .summary h3 {
            font-size: 10px;
            color: #4F46E5;
            margin-bottom: 5px;
        }
        .summary-grid {
            display: table;
            width: 100%;
        }
        .summary-item {
            display: table-cell;
            width: 12.5%;
            padding: 3px;
            text-align: center;
            border-right: 1px solid #c7d2fe;
        }
        .summary-item:last-child {
            border-right: none;
        }
        .summary-value {
            font-size: 9px;
            font-weight: bold;
            color: #4F46E5;
        }
        .summary-label {
            font-size: 6px;
            color: #666;
        }
        .badge {
            display: inline-block;
            padding: 1px 3px;
            border-radius: 3px;
            font-size: 5px;
        }
        .badge-yes {
            background-color: #d1fae5;
            color: #065f46;
        }
        .badge-no {
            background-color: #f3f4f6;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>MFI Database - Complete Report</h1>
        <p>Generated on: {{ date('F d, Y h:i A') }} | Total Records: {{ $mfis->count() }} | All 23 Columns</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 2%;">SL</th>
                <th style="width: 4%;">License No. of MFI</th>
                <th style="width: 4%;">Licence No.</th>
                <th style="width: 6%;">Name of MFI</th>
                <th style="width: 7%;">Full Name</th>
                <th style="width: 3%;">Sort Name</th>
                <th style="width: 2%;">T-50</th>
                <th style="width: 2%;">CDF</th>
                <th style="width: 2%;">T-100</th>
                <th style="width: 2%;">PKSF</th>
                <th style="width: 8%;">Current Address</th>
                <th style="width: 5%;">Phone</th>
                <th style="width: 6%;">Email</th>
                <th style="width: 3%;">Branches</th>
                <th style="width: 4%;">Employees</th>
                <th style="width: 4%;">Clients</th>
                <th style="width: 4%;">Borrowers</th>
                <th style="width: 5%;">Savings (BDT)</th>
                <th style="width: 6%;">Disbursement (BDT)</th>
                <th style="width: 6%;">Outstanding (BDT)</th>
                <th style="width: 4%;">Division</th>
                <th style="width: 4%;">District</th>
                <th style="width: 3%;">Dhaka Area</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mfis as $mfi)
                <tr>
                    <td class="text-center">{{ $mfi->sl_no }}</td>
                    <td>{{ $mfi->license_number_of_mfi }}</td>
                    <td>{{ $mfi->licence_no }}</td>
                    <td class="truncate" title="{{ $mfi->name_of_mfi }}">{{ Str::limit($mfi->name_of_mfi, 20) }}</td>
                    <td class="truncate" title="{{ $mfi->name_without_abbreviation }}">{{ Str::limit($mfi->name_without_abbreviation, 25) }}</td>
                    <td>{{ $mfi->sort_name }}</td>
                    <td class="text-center">
                        <span class="badge {{ strtolower($mfi->t_50) == 'yes' ? 'badge-yes' : 'badge-no' }}">{{ $mfi->t_50 }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge {{ strtolower($mfi->cdf) == 'yes' ? 'badge-yes' : 'badge-no' }}">{{ $mfi->cdf }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge {{ strtolower($mfi->t_100) == 'yes' ? 'badge-yes' : 'badge-no' }}">{{ $mfi->t_100 }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge {{ strtolower($mfi->pksf) == 'yes' ? 'badge-yes' : 'badge-no' }}">{{ $mfi->pksf }}</span>
                    </td>
                    <td class="truncate" title="{{ $mfi->current_address }}">{{ Str::limit($mfi->current_address, 30) }}</td>
                    <td>{{ $mfi->phone }}</td>
                    <td class="truncate">{{ Str::limit($mfi->email, 20) }}</td>
                    <td class="text-right">{{ number_format($mfi->no_of_branches) }}</td>
                    <td class="text-right">{{ number_format($mfi->number_of_employees_total) }}</td>
                    <td class="text-right">{{ number_format($mfi->number_of_clients_total) }}</td>
                    <td class="text-right">{{ number_format($mfi->number_of_borrowers_total) }}</td>
                    <td class="text-right">{{ number_format($mfi->savings_bdt, 0) }}</td>
                    <td class="text-right">{{ number_format($mfi->loan_disbursement_bdt, 0) }}</td>
                    <td class="text-right">{{ number_format($mfi->loan_outstanding_bdt, 0) }}</td>
                    <td>{{ $mfi->division }}</td>
                    <td>{{ $mfi->district }}</td>
                    <td class="text-center">
                        <span class="badge {{ strtolower($mfi->dhaka_area) == 'yes' ? 'badge-yes' : 'badge-no' }}">{{ $mfi->dhaka_area }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <h3>Summary Statistics</h3>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-value">{{ number_format($mfis->count()) }}</div>
                <div class="summary-label">Total MFIs</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ number_format($mfis->sum('no_of_branches')) }}</div>
                <div class="summary-label">Total Branches</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ number_format($mfis->sum('number_of_employees_total')) }}</div>
                <div class="summary-label">Total Employees</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ number_format($mfis->sum('number_of_clients_total')) }}</div>
                <div class="summary-label">Total Clients</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ number_format($mfis->sum('number_of_borrowers_total')) }}</div>
                <div class="summary-label">Total Borrowers</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">৳{{ number_format($mfis->sum('savings_bdt'), 0) }}</div>
                <div class="summary-label">Total Savings</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">৳{{ number_format($mfis->sum('loan_disbursement_bdt'), 0) }}</div>
                <div class="summary-label">Total Disbursement</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">৳{{ number_format($mfis->sum('loan_outstanding_bdt'), 0) }}</div>
                <div class="summary-label">Total Outstanding</div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>MFI Database Management System | Confidential Report | <span class="page-number"></span></p>
    </div>
</body>
</html>