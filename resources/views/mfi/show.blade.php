@extends('layouts.app')

@section('title', 'View MFI')
@section('header', 'MFI Details')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('mfi.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-arrow-left mr-2"></i>Back to List
        </a>
    </div>

    <!-- MFI Header Card -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl shadow-lg p-6 text-white mb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold">{{ $mfi->name_of_mfi }}</h1>
                <p class="text-indigo-100 mt-1">{{ $mfi->name_without_abbreviation }}</p>
                <div class="flex items-center gap-4 mt-4">
                    <span class="inline-flex items-center px-3 py-1 bg-white/20 rounded-full text-sm">
                        <i class="fas fa-id-card mr-2"></i>{{ $mfi->license_number_of_mfi }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 bg-white/20 rounded-full text-sm">
                        <i class="fas fa-map-marker-alt mr-2"></i>{{ $mfi->division }}, {{ $mfi->district }}
                    </span>
                </div>
            </div>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('mfi.edit', $mfi) }}" class="px-4 py-2 bg-white text-indigo-600 rounded-lg hover:bg-gray-100 transition-colors font-medium">
                    <i class="fas fa-edit mr-2"></i>Edit Record
                </a>
            @endif
        </div>
    </div>

    <!-- Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Basic Information -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-info-circle text-indigo-600 mr-2"></i>Basic Information
            </h2>
            <div class="space-y-4">
                @foreach(['sl_no', 'license_number_of_mfi', 'licence_no', 'name_of_mfi', 'name_without_abbreviation', 'sort_name'] as $field)
                    <div class="flex flex-col sm:flex-row sm:items-center py-2 border-b border-gray-100 last:border-0">
                        <span class="text-sm font-medium text-gray-500 sm:w-1/2">{{ $columnLabels[$field] }}</span>
                        <span class="text-gray-800 sm:w-1/2">{{ $mfi->$field ?? '-' }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Category Information -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-tags text-indigo-600 mr-2"></i>Categories
            </h2>
            <div class="grid grid-cols-2 gap-4">
                @foreach(['t_50', 'cdf', 't_100', 'pksf'] as $field)
                    <div class="p-4 bg-gray-50 rounded-lg text-center">
                        <span class="block text-sm text-gray-500 mb-1">{{ $columnLabels[$field] }}</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ strtolower($mfi->$field) == 'yes' ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-600' }}">
                            {{ $mfi->$field ?? '-' }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Contact Information -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-address-book text-indigo-600 mr-2"></i>Contact Information
            </h2>
            <div class="space-y-4">
                <div class="flex flex-col py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-500">{{ $columnLabels['current_address'] }}</span>
                    <span class="text-gray-800 mt-1">{{ $mfi->current_address ?? '-' }}</span>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-500 sm:w-1/3">{{ $columnLabels['phone'] }}</span>
                    <span class="text-gray-800 sm:w-2/3">
                        @if($mfi->phone)
                            <a href="tel:{{ $mfi->phone }}" class="text-indigo-600 hover:underline">{{ $mfi->phone }}</a>
                        @else
                            -
                        @endif
                    </span>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-500 sm:w-1/3">{{ $columnLabels['email'] }}</span>
                    <span class="text-gray-800 sm:w-2/3">
                        @if($mfi->email)
                            <a href="mailto:{{ $mfi->email }}" class="text-indigo-600 hover:underline">{{ $mfi->email }}</a>
                        @else
                            -
                        @endif
                    </span>
                </div>
                @foreach(['division', 'district', 'dhaka_area'] as $field)
                    <div class="flex flex-col sm:flex-row sm:items-center py-2 border-b border-gray-100 last:border-0">
                        <span class="text-sm font-medium text-gray-500 sm:w-1/3">{{ $columnLabels[$field] }}</span>
                        <span class="text-gray-800 sm:w-2/3">{{ $mfi->$field ?? '-' }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Operational Data -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-chart-bar text-indigo-600 mr-2"></i>Operational Data
            </h2>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-blue-50 rounded-lg text-center">
                        <span class="block text-2xl font-bold text-blue-600">{{ number_format($mfi->no_of_branches ?? 0) }}</span>
                        <span class="text-sm text-gray-600">Branches</span>
                    </div>
                    <div class="p-4 bg-green-50 rounded-lg text-center">
                        <span class="block text-2xl font-bold text-green-600">{{ number_format($mfi->number_of_employees_total ?? 0) }}</span>
                        <span class="text-sm text-gray-600">Employees</span>
                    </div>
                    <div class="p-4 bg-purple-50 rounded-lg text-center">
                        <span class="block text-2xl font-bold text-purple-600">{{ number_format($mfi->number_of_clients_total ?? 0) }}</span>
                        <span class="text-sm text-gray-600">Clients</span>
                    </div>
                    <div class="p-4 bg-orange-50 rounded-lg text-center">
                        <span class="block text-2xl font-bold text-orange-600">{{ number_format($mfi->number_of_borrowers_total ?? 0) }}</span>
                        <span class="text-sm text-gray-600">Borrowers</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Information -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mt-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-money-bill-wave text-indigo-600 mr-2"></i>Financial Information
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-6 bg-gradient-to-br from-emerald-50 to-green-50 rounded-xl border border-emerald-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-600">{{ $columnLabels['savings_bdt'] }}</span>
                    <i class="fas fa-piggy-bank text-emerald-500"></i>
                </div>
                <span class="text-2xl font-bold text-emerald-600">৳ {{ number_format($mfi->savings_bdt ?? 0, 2) }}</span>
            </div>
            <div class="p-6 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-600">{{ $columnLabels['loan_disbursement_bdt'] }}</span>
                    <i class="fas fa-hand-holding-usd text-blue-500"></i>
                </div>
                <span class="text-2xl font-bold text-blue-600">৳ {{ number_format($mfi->loan_disbursement_bdt ?? 0, 2) }}</span>
            </div>
            <div class="p-6 bg-gradient-to-br from-orange-50 to-amber-50 rounded-xl border border-orange-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-600">{{ $columnLabels['loan_outstanding_bdt'] }}</span>
                    <i class="fas fa-file-invoice-dollar text-orange-500"></i>
                </div>
                <span class="text-2xl font-bold text-orange-600">৳ {{ number_format($mfi->loan_outstanding_bdt ?? 0, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Timestamps -->
    <div class="mt-6 text-sm text-gray-500 flex items-center justify-between">
        <span>Created: {{ $mfi->created_at?->format('M d, Y h:i A') ?? 'N/A' }}</span>
        <span>Last Updated: {{ $mfi->updated_at?->format('M d, Y h:i A') ?? 'N/A' }}</span>
    </div>
</div>
@endsection