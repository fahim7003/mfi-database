@extends('layouts.app')

@section('title', 'MFI Data')
@section('header', 'MFI Data')

@section('content')
<div class="space-y-6" x-data="{ 
    showFilters: false, 
    showColumnSelector: false, 
    visibleColumns: {
    sl_no: true,
    license_number_of_mfi: true,
    licence_no: true,
    name_of_mfi: true,
    name_without_abbreviation: true,
    sort_name: true,
    t_50: true,
    cdf: true,
    t_100: true,
    pksf: true,
    current_address: true,
    phone: true,
    email: true,
    no_of_branches: true,
    number_of_employees_total: true,
    number_of_clients_total: true,
    number_of_borrowers_total: true,
    savings_bdt: true,
    loan_disbursement_bdt: true,
    loan_outstanding_bdt: true,
    division: true,
    district: true,
    dhaka_area: true
}}">
   
    <!-- Search and Filter Bar -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <form action="{{ route('mfi.index') }}" method="GET" id="filterForm">
            <!-- Global Search -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-4">
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fas fa-search"></i>
                        </span>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search for..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>
                </div>
               
                <div class="flex flex-wrap items-center gap-3">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                   
                    <button type="button" @click="showFilters = !showFilters" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        <i class="fas fa-filter mr-2"></i>Filters
                        <i class="fas fa-chevron-down ml-1 text-xs transition-transform" :class="showFilters && 'rotate-180'"></i>
                    </button>

                    <button type="button" @click="showColumnSelector = !showColumnSelector" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        <i class="fas fa-columns mr-2"></i>Columns
                    </button>
                   
                    <a href="{{ route('mfi.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        <i class="fas fa-redo mr-2"></i>Reset
                    </a>
                </div>
            </div>

            <!-- Column Selector Panel -->
            <div x-show="showColumnSelector" x-collapse class="border-t pt-4 mt-4 mb-4">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Toggle Visible Columns:</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2">
                    @foreach($columnLabels as $key => $label)
                        <label class="flex items-center space-x-2 text-sm cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="checkbox" x-model="visibleColumns.{{ $key }}" class="rounded text-indigo-600 focus:ring-indigo-500">
                            <span class="text-gray-700 truncate" title="{{ $label }}">{{ Str::limit($label, 20) }}</span>
                        </label>
                    @endforeach
                </div>
                <div class="mt-3 flex gap-2">
                    <button type="button" @click="Object.keys(visibleColumns).forEach(k => visibleColumns[k] = true)" class="text-sm text-indigo-600 hover:text-indigo-800">
                        <i class="fas fa-check-double mr-1"></i>Select All
                    </button>
                    <button type="button" @click="Object.keys(visibleColumns).forEach(k => visibleColumns[k] = false)" class="text-sm text-red-600 hover:text-red-800">
                        <i class="fas fa-times mr-1"></i>Deselect All
                    </button>
                </div>
            </div>

            <!-- Advanced Filters Panel -->
            <div x-show="showFilters" x-collapse class="border-t pt-4 mt-4">
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <!-- Division Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Division</label>
                        <select name="filter_division" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Divisions</option>
                            @foreach($filterOptions['division'] ?? [] as $option)
                                <option value="{{ $option }}" {{ request('filter_division') == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- District Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">District</label>
                        <select name="filter_district" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Districts</option>
                            @foreach($filterOptions['district'] ?? [] as $option)
                                <option value="{{ $option }}" {{ request('filter_district') == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- T-50 Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">T-50</label>
                        <select name="filter_t_50" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All</option>
                            <option value="">All</option>
                            <option value="Yes" {{ request('filter_t_50') == 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ request('filter_t_50') == 'No' ? 'selected' : '' }}>No</option>
                        {{-- @foreach($filterOptions['t_50'] ?? [] as $option)
                                <option value="{{ $option }}" {{ request('filter_t_50') == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach --}}
                        </select>
                    </div>

                    <!-- CDF Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">CDF</label>
                        <select name="filter_cdf" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All</option>
                            <option value="Yes" {{ request('filter_cdf') == 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ request('filter_cdf') == 'No' ? 'selected' : '' }}>No</option>
                            {{-- @foreach($filterOptions['cdf'] ?? [] as $option)
                                <option value="{{ $option }}" {{ request('filter_cdf') == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- T-100 Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">T-100</label>
                        <select name="filter_t_100" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All</option>
                            <option value="Yes" {{ request('filter_t_100') == 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ request('filter_t_100') == 'No' ? 'selected' : '' }}>No</option>
                            {{-- @foreach($filterOptions['t_100'] ?? [] as $option)
                                <option value="{{ $option }}" {{ request('filter_t_100') == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach --}}
                        </select>
                    </div>

                    <!-- PKSF Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">PKSF</label>
                        <select name="filter_pksf" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All</option>
                            <option value="Yes" {{ request('filter_pksf') == 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ request('filter_pksf') == 'No' ? 'selected' : '' }}>No</option>
                            {{-- @foreach($filterOptions['pksf'] ?? [] as $option)
                                <option value="{{ $option }}" {{ request('filter_pksf') == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach --}}
                        </select>
                    </div>

                    <!-- Name of MFI -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name of MFI</label>
                        <input type="text" name="filter_name_of_mfi" value="{{ request('filter_name_of_mfi') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Search by name...">
                    </div>

                    <!-- License Number -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">License Number</label>
                        <input type="text" name="filter_license_number_of_mfi" value="{{ request('filter_license_number_of_mfi') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Search by license...">
                    </div>

                    <!-- Dhaka Area -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dhaka Area</label>
                        <select name="filter_dhaka_area" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All</option>
                            @foreach($filterOptions['dhaka_area'] ?? [] as $option)
                                <option value="{{ $option }}" {{ request('filter_dhaka_area') == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Controls Bar (Per Page, Record Count, Export Buttons) -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- Left Side: Per Page & Record Count -->
            <div class="flex flex-wrap items-center gap-4">
                <!-- Per Page Selector -->
                <div class="flex items-center gap-2">
                    <label for="per_page_select" class="text-sm font-medium text-gray-700">Show:</label>
                    <select id="per_page_select"
                            onchange="updatePerPage(this.value)"
                            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                        @foreach([10, 15, 25, 50, 100, 200] as $perPage)
                            <option value="{{ $perPage }}" {{ request('per_page', 15) == $perPage ? 'selected' : '' }}>
                                {{ $perPage }} rows
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Divider -->
                <div class="hidden md:block w-px h-6 bg-gray-300"></div>

                <!-- Record Count -->
                <div class="text-sm text-gray-600">
                    <span class="font-medium text-gray-800">{{ $mfis->firstItem() ?? 0 }}</span>
                    to
                    <span class="font-medium text-gray-800">{{ $mfis->lastItem() ?? 0 }}</span>
                    of
                    <span class="font-medium text-indigo-600">{{ $mfis->total() }}</span>
                    records
                </div>
            </div>

            <!-- Right Side: Export Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-sm text-gray-500 mr-2">Export:</span>
                <a href="{{ route('export.excel', request()->query()) }}"
                class="inline-flex items-center px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm">
                    <i class="fas fa-file-excel mr-2"></i>Excel
                </a>
                <a href="{{ route('export.csv', request()->query()) }}"
                class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                    <i class="fas fa-file-csv mr-2"></i>CSV
                </a>
                <a href="{{ route('export.pdf', request()->query()) }}"
                class="inline-flex items-center px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm">
                    <i class="fas fa-file-pdf mr-2"></i>PDF
                </a>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm whitespace-nowrap">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <!-- SL No -->
                        <th x-show="visibleColumns.sl_no" class="px-4 py-3 text-left font-semibold text-gray-700">
                            <a href="{{ route('mfi.index', array_merge(request()->query(), ['sort' => 'sl_no', 'direction' => ($sortColumn == 'sl_no' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}"
                               class="flex items-center hover:text-indigo-600">
                                SL No.
                                @if($sortColumn == 'sl_no')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>

                        <!-- License Number of MFI -->
                        <th x-show="visibleColumns.license_number_of_mfi" class="px-4 py-3 text-left font-semibold text-gray-700">
                            <a href="{{ route('mfi.index', array_merge(request()->query(), ['sort' => 'license_number_of_mfi', 'direction' => ($sortColumn == 'license_number_of_mfi' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}"
                               class="flex items-center hover:text-indigo-600">
                                License Number
                                @if($sortColumn == 'license_number_of_mfi')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>

                        <!-- Licence No -->
                        <th x-show="visibleColumns.licence_no" class="px-4 py-3 text-left font-semibold text-gray-700">
                            <a href="{{ route('mfi.index', array_merge(request()->query(), ['sort' => 'licence_no', 'direction' => ($sortColumn == 'licence_no' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}"
                               class="flex items-center hover:text-indigo-600">
                                Licence No.
                                @if($sortColumn == 'licence_no')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>

                        <!-- Name of MFI -->
                        <th x-show="visibleColumns.name_of_mfi" class="px-4 py-3 text-left font-semibold text-gray-700">
                            <a href="{{ route('mfi.index', array_merge(request()->query(), ['sort' => 'name_of_mfi', 'direction' => ($sortColumn == 'name_of_mfi' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}"
                               class="flex items-center hover:text-indigo-600">
                                Name of MFI
                                @if($sortColumn == 'name_of_mfi')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>

                        <!-- Name without abbreviation -->
                        <th x-show="visibleColumns.name_without_abbreviation" class="px-4 py-3 text-left font-semibold text-gray-700">
                            <a href="{{ route('mfi.index', array_merge(request()->query(), ['sort' => 'name_without_abbreviation', 'direction' => ($sortColumn == 'name_without_abbreviation' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}"
                               class="flex items-center hover:text-indigo-600">
                                Full Name
                                @if($sortColumn == 'name_without_abbreviation')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>

                        <!-- Sort Name -->
                        <th x-show="visibleColumns.sort_name" class="px-4 py-3 text-left font-semibold text-gray-700">
                            <a href="{{ route('mfi.index', array_merge(request()->query(), ['sort' => 'sort_name', 'direction' => ($sortColumn == 'sort_name' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}"
                               class="flex items-center hover:text-indigo-600">
                                Sort Name
                                @if($sortColumn == 'sort_name')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>

                        <!-- T-50 -->
                        <th x-show="visibleColumns.t_50" class="px-4 py-3 text-left font-semibold text-gray-700">
                            <a href="{{ route('mfi.index', array_merge(request()->query(), ['sort' => 't_50', 'direction' => ($sortColumn == 't_50' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}"
                               class="flex items-center hover:text-indigo-600">
                                T-50
                                @if($sortColumn == 't_50')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>

                        <!-- CDF -->
                        <th x-show="visibleColumns.cdf" class="px-4 py-3 text-left font-semibold text-gray-700">
                            <a href="{{ route('mfi.index', array_merge(request()->query(), ['sort' => 'cdf', 'direction' => ($sortColumn == 'cdf' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}"
                               class="flex items-center hover:text-indigo-600">
                                CDF
                                @if($sortColumn == 'cdf')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>

                        <!-- T-100 -->
                        <th x-show="visibleColumns.t_100" class="px-4 py-3 text-left font-semibold text-gray-700">
                            <a href="{{ route('mfi.index', array_merge(request()->query(), ['sort' => 't_100', 'direction' => ($sortColumn == 't_100' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}"
                               class="flex items-center hover:text-indigo-600">
                                T-100
                                @if($sortColumn == 't_100')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>

                        <!-- PKSF -->
                        <th x-show="visibleColumns.pksf" class="px-4 py-3 text-left font-semibold text-gray-700">
                            <a href="{{ route('mfi.index', array_merge(request()->query(), ['sort' => 'pksf', 'direction' => ($sortColumn == 'pksf' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}"
                               class="flex items-center hover:text-indigo-600">
                                PKSF
                                @if($sortColumn == 'pksf')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>

                        <!-- Current Address -->
                        <th x-show="visibleColumns.current_address" class="px-4 py-3 text-left font-semibold text-gray-700">
                            <a href="{{ route('mfi.index', array_merge(request()->query(), ['sort' => 'current_address', 'direction' => ($sortColumn == 'current_address' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}"
                               class="flex items-center hover:text-indigo-600">
                                Address
                                @if($sortColumn == 'current_address')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>

                        <!-- Phone -->
                        <th x-show="visibleColumns.phone" class="px-4 py-3 text-left font-semibold text-gray-700">
                            <a href="{{ route('mfi.index', array_merge(request()->query(), ['sort' => 'phone', 'direction' => ($sortColumn == 'phone' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}"
                               class="flex items-center hover:text-indigo-600">
                                Phone
                                @if($sortColumn == 'phone')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>

                        <!-- Email -->
                        <th x-show="visibleColumns.email" class="px-4 py-3 text-left font-semibold text-gray-700">
                            <a href="{{ route('mfi.index', array_merge(request()->query(), ['sort' => 'email', 'direction' => ($sortColumn == 'email' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}"
                               class="flex items-center hover:text-indigo-600">
                                Email
                                @if($sortColumn == 'email')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>

                        <!-- No of Branches -->
                        <th x-show="visibleColumns.no_of_branches" class="px-4 py-3 text-left font-semibold text-gray-700">
                            <a href="{{ route('mfi.index', array_merge(request()->query(), ['sort' => 'no_of_branches', 'direction' => ($sortColumn == 'no_of_branches' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}"
                               class="flex items-center hover:text-indigo-600">
                                Branches
                                @if($sortColumn == 'no_of_branches')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>

                        <!-- Number of Employees Total -->
                        <th x-show="visibleColumns.number_of_employees_total" class="px-4 py-3 text-left font-semibold text-gray-700">
                            <a href="{{ route('mfi.index', array_merge(request()->query(), ['sort' => 'number_of_employees_total', 'direction' => ($sortColumn == 'number_of_employees_total' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}"
                               class="flex items-center hover:text-indigo-600">
                                Employees
                                @if($sortColumn == 'number_of_employees_total')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>

                        <!-- Number of Clients Total -->
                        <th x-show="visibleColumns.number_of_clients_total" class="px-4 py-3 text-left font-semibold text-gray-700">
                            <a href="{{ route('mfi.index', array_merge(request()->query(), ['sort' => 'number_of_clients_total', 'direction' => ($sortColumn == 'number_of_clients_total' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}"
                               class="flex items-center hover:text-indigo-600">
                                Clients
                                @if($sortColumn == 'number_of_clients_total')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>

                        <!-- Number of Borrowers Total -->
                        <th x-show="visibleColumns.number_of_borrowers_total" class="px-4 py-3 text-left font-semibold text-gray-700">
                            <a href="{{ route('mfi.index', array_merge(request()->query(), ['sort' => 'number_of_borrowers_total', 'direction' => ($sortColumn == 'number_of_borrowers_total' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}"
                               class="flex items-center hover:text-indigo-600">
                                Borrowers
                                @if($sortColumn == 'number_of_borrowers_total')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>

                        <!-- Savings BDT -->
                        <th x-show="visibleColumns.savings_bdt" class="px-4 py-3 text-left font-semibold text-gray-700">
                            <a href="{{ route('mfi.index', array_merge(request()->query(), ['sort' => 'savings_bdt', 'direction' => ($sortColumn == 'savings_bdt' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}"
                               class="flex items-center hover:text-indigo-600">
                                Savings (BDT)
                                @if($sortColumn == 'savings_bdt')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>

                        <!-- Loan Disbursement BDT -->
                        <th x-show="visibleColumns.loan_disbursement_bdt" class="px-4 py-3 text-left font-semibold text-gray-700">
                            <a href="{{ route('mfi.index', array_merge(request()->query(), ['sort' => 'loan_disbursement_bdt', 'direction' => ($sortColumn == 'loan_disbursement_bdt' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}"
                               class="flex items-center hover:text-indigo-600">
                                Disbursement (BDT)
                                @if($sortColumn == 'loan_disbursement_bdt')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>

                        <!-- Loan Outstanding BDT -->
                        <th x-show="visibleColumns.loan_outstanding_bdt" class="px-4 py-3 text-left font-semibold text-gray-700">
                            <a href="{{ route('mfi.index', array_merge(request()->query(), ['sort' => 'loan_outstanding_bdt', 'direction' => ($sortColumn == 'loan_outstanding_bdt' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}"
                               class="flex items-center hover:text-indigo-600">
                                Outstanding (BDT)
                                @if($sortColumn == 'loan_outstanding_bdt')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>

                        <!-- Division -->
                        <th x-show="visibleColumns.division" class="px-4 py-3 text-left font-semibold text-gray-700">
                            <a href="{{ route('mfi.index', array_merge(request()->query(), ['sort' => 'division', 'direction' => ($sortColumn == 'division' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}"
                               class="flex items-center hover:text-indigo-600">
                                Division
                                @if($sortColumn == 'division')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>

                        <!-- District -->
                        <th x-show="visibleColumns.district" class="px-4 py-3 text-left font-semibold text-gray-700">
                            <a href="{{ route('mfi.index', array_merge(request()->query(), ['sort' => 'district', 'direction' => ($sortColumn == 'district' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}"
                               class="flex items-center hover:text-indigo-600">
                                District
                                @if($sortColumn == 'district')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>

                        <!-- Dhaka Area -->
                        <th x-show="visibleColumns.dhaka_area" class="px-4 py-3 text-left font-semibold text-gray-700">
                            <a href="{{ route('mfi.index', array_merge(request()->query(), ['sort' => 'dhaka_area', 'direction' => ($sortColumn == 'dhaka_area' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}"
                               class="flex items-center hover:text-indigo-600">
                                Dhaka Area
                                @if($sortColumn == 'dhaka_area')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>

                        <!-- Actions -->
                        <th class="px-4 py-3 text-center font-semibold text-gray-700 sticky right-0 bg-gray-50">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($mfis as $mfi)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td x-show="visibleColumns.sl_no" class="px-4 py-3">{{ $mfi->sl_no ?? '-' }}</td>
                            <td x-show="visibleColumns.license_number_of_mfi" class="px-4 py-3 font-medium text-indigo-600">{{ $mfi->license_number_of_mfi ?? '-' }}</td>
                            <td x-show="visibleColumns.licence_no" class="px-4 py-3">{{ $mfi->licence_no ?? '-' }}</td>
                            <td x-show="visibleColumns.name_of_mfi" class="px-4 py-3">
                                <div class="max-w-xs truncate" title="{{ $mfi->name_of_mfi }}">{{ $mfi->name_of_mfi ?? '-' }}</div>
                            </td>
                            <td x-show="visibleColumns.name_without_abbreviation" class="px-4 py-3">
                                <div class="max-w-xs truncate" title="{{ $mfi->name_without_abbreviation }}">{{ $mfi->name_without_abbreviation ?? '-' }}</div>
                            </td>
                            <td x-show="visibleColumns.sort_name" class="px-4 py-3">{{ $mfi->sort_name ?? '-' }}</td>
                            <td x-show="visibleColumns.t_50" class="px-4 py-3">
                                <span class="inline-flex px-2 py-1 text-xs rounded-full {{ strtolower($mfi->t_50) == 'yes' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $mfi->t_50 ?? '-' }}
                                </span>
                            </td>
                            <td x-show="visibleColumns.cdf" class="px-4 py-3">
                                <span class="inline-flex px-2 py-1 text-xs rounded-full {{ strtolower($mfi->cdf) == 'yes' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $mfi->cdf ?? '-' }}
                                </span>
                            </td>
                            <td x-show="visibleColumns.t_100" class="px-4 py-3">
                                <span class="inline-flex px-2 py-1 text-xs rounded-full {{ strtolower($mfi->t_100) == 'yes' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $mfi->t_100 ?? '-' }}
                                </span>
                            </td>
                            <td x-show="visibleColumns.pksf" class="px-4 py-3">
                                <span class="inline-flex px-2 py-1 text-xs rounded-full {{ strtolower($mfi->pksf) == 'yes' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $mfi->pksf ?? '-' }}
                                </span>
                            </td>
                            <td x-show="visibleColumns.current_address" class="px-4 py-3">
                                <div class="max-w-xs truncate" title="{{ $mfi->current_address }}">{{ $mfi->current_address ?? '-' }}</div>
                            </td>
                            <td x-show="visibleColumns.phone" class="px-4 py-3">{{ $mfi->phone ?? '-' }}</td>
                            <td x-show="visibleColumns.email" class="px-4 py-3">
                                @if($mfi->email)
                                    <a href="mailto:{{ $mfi->email }}" class="text-indigo-600 hover:underline">{{ $mfi->email }}</a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td x-show="visibleColumns.no_of_branches" class="px-4 py-3 text-right">{{ $mfi->no_of_branches ? number_format($mfi->no_of_branches) : '-' }}</td>
                            <td x-show="visibleColumns.number_of_employees_total" class="px-4 py-3 text-right">{{ $mfi->number_of_employees_total ? number_format($mfi->number_of_employees_total) : '-' }}</td>
                            <td x-show="visibleColumns.number_of_clients_total" class="px-4 py-3 text-right">{{ $mfi->number_of_clients_total ? number_format($mfi->number_of_clients_total) : '-' }}</td>
                            <td x-show="visibleColumns.number_of_borrowers_total" class="px-4 py-3 text-right">{{ $mfi->number_of_borrowers_total ? number_format($mfi->number_of_borrowers_total) : '-' }}</td>
                            <td x-show="visibleColumns.savings_bdt" class="px-4 py-3 text-right">{{ $mfi->savings_bdt ? '৳' . number_format($mfi->savings_bdt, 2) : '-' }}</td>
                            <td x-show="visibleColumns.loan_disbursement_bdt" class="px-4 py-3 text-right">{{ $mfi->loan_disbursement_bdt ? '৳' . number_format($mfi->loan_disbursement_bdt, 2) : '-' }}</td>
                            <td x-show="visibleColumns.loan_outstanding_bdt" class="px-4 py-3 text-right">{{ $mfi->loan_outstanding_bdt ? '৳' . number_format($mfi->loan_outstanding_bdt, 2) : '-' }}</td>
                            <td x-show="visibleColumns.division" class="px-4 py-3">{{ $mfi->division ?? '-' }}</td>
                            <td x-show="visibleColumns.district" class="px-4 py-3">{{ $mfi->district ?? '-' }}</td>
                            <td x-show="visibleColumns.dhaka_area" class="px-4 py-3">
                                <span class="inline-flex px-2 py-1 text-xs rounded-full {{ strtolower($mfi->dhaka_area) == 'yes' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $mfi->dhaka_area ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 sticky right-0 bg-white">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('mfi.show', $mfi) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('mfi.edit', $mfi) }}" class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('mfi.destroy', $mfi) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this record?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="24" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                    <p class="text-gray-500 font-medium">No records found</p>
                                    <p class="text-gray-400 text-sm">Try adjusting your search or filter criteria</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($mfis->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $mfis->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    [x-collapse] {
        overflow: hidden;
    }
    [x-collapse].collapsed {
        height: 0;
    }
    /* Make actions column sticky */
    .sticky {
        position: sticky;
        z-index: 10;
    }
    /* Add shadow to sticky column */
    .sticky.right-0 {
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
    }
</style>
@endpush
