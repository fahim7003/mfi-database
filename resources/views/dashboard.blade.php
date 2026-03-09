@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">Welcome back, {{ auth()->user()->name }}!</h2>
                <p class="text-indigo-100 mt-1">Here's an overview of your MFI database.</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-chart-line text-6xl text-white/20"></i>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total MFIs -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-building text-2xl text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total MFIs</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_mfis']) }}</p>
                </div>
            </div>
        </div>

        <!-- Total Branches -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-code-branch text-2xl text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Branches</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_branches']) }}</p>
                </div>
            </div>
        </div>

        <!-- Total Employees -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-users text-2xl text-yellow-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Employees</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_employees']) }}</p>
                </div>
            </div>
        </div>

        <!-- Total Clients -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-user-friends text-2xl text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Clients</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_clients']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Savings -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Total Savings</h3>
                <span class="p-2 bg-emerald-100 rounded-lg">
                    <i class="fas fa-piggy-bank text-emerald-600"></i>
                </span>
            </div>
            <p class="text-3xl font-bold text-emerald-600">৳ {{ number_format($stats['total_savings'], 2) }}</p>
            <p class="text-sm text-gray-500 mt-2">Accumulated savings across all MFIs</p>
        </div>

        <!-- Total Disbursement -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Loan Disbursement</h3>
                <span class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-hand-holding-usd text-blue-600"></i>
                </span>
            </div>
            <p class="text-3xl font-bold text-blue-600">৳ {{ number_format($stats['total_disbursement'], 2) }}</p>
            <p class="text-sm text-gray-500 mt-2">Total loans disbursed</p>
        </div>

        <!-- Outstanding Loans -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Outstanding Loans</h3>
                <span class="p-2 bg-orange-100 rounded-lg">
                    <i class="fas fa-file-invoice-dollar text-orange-600"></i>
                </span>
            </div>
            <p class="text-3xl font-bold text-orange-600">৳ {{ number_format($stats['total_outstanding'], 2) }}</p>
            <p class="text-sm text-gray-500 mt-2">Current outstanding amount</p>
        </div>
    </div>

    <!-- Quick Actions & Division Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('mfi.index') }}" class="flex items-center p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                    <i class="fas fa-table text-indigo-600 text-xl mr-3"></i>
                    <span class="font-medium text-gray-700">View All MFIs</span>
                </a>
                <a href="{{ route('export.excel') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <i class="fas fa-file-excel text-green-600 text-xl mr-3"></i>
                    <span class="font-medium text-gray-700">Export Excel</span>
                </a>
                <a href="{{ route('export.pdf') }}" class="flex items-center p-4 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                    <i class="fas fa-file-pdf text-red-600 text-xl mr-3"></i>
                    <span class="font-medium text-gray-700">Export PDF</span>
                </a>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('users.index') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <i class="fas fa-user-cog text-purple-600 text-xl mr-3"></i>
                    <span class="font-medium text-gray-700">Manage Users</span>
                </a>
                @else
                <a href="{{ route('export.csv') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <i class="fas fa-file-csv text-blue-600 text-xl mr-3"></i>
                    <span class="font-medium text-gray-700">Export CSV</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Division Distribution -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">MFI by Division</h3>
            <div class="space-y-3">
                @foreach($divisions as $division)
                    @php
                        $count = \App\Models\Mfi::where('division', $division)->count();
                        $percentage = $stats['total_mfis'] > 0 ? ($count / $stats['total_mfis']) * 100 : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">{{ $division }}</span>
                            <span class="font-medium text-gray-800">{{ $count }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Borrowers Stats -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Borrower Statistics</h3>
            <a href="{{ route('mfi.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                View Details <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Borrowers</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_borrowers']) }}</p>
                </div>
            </div>
            <div class="flex items-center">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-percentage text-white text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Borrower to Client Ratio</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ $stats['total_clients'] > 0 ? number_format(($stats['total_borrowers'] / $stats['total_clients']) * 100, 1) : 0 }}%
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection