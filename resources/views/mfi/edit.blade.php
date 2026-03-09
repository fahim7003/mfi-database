@extends('layouts.app')

@section('title', 'Edit MFI')
@section('header', 'Edit MFI Record')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('mfi.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-arrow-left mr-2"></i>Back to List
        </a>
    </div>

    <form action="{{ route('mfi.update', $mfi) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-info-circle text-indigo-600 mr-2"></i>Basic Information
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $columnLabels['sl_no'] }}</label>
                        <input type="number" name="sl_no" value="{{ old('sl_no', $mfi->sl_no) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $columnLabels['license_number_of_mfi'] }}</label>
                        <input type="text" name="license_number_of_mfi" value="{{ old('license_number_of_mfi', $mfi->license_number_of_mfi) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $columnLabels['licence_no'] }}</label>
                        <input type="text" name="licence_no" value="{{ old('licence_no', $mfi->licence_no) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $columnLabels['name_of_mfi'] }}</label>
                        <input type="text" name="name_of_mfi" value="{{ old('name_of_mfi', $mfi->name_of_mfi) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $columnLabels['sort_name'] }}</label>
                        <input type="text" name="sort_name" value="{{ old('sort_name', $mfi->sort_name) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $columnLabels['name_without_abbreviation'] }}</label>
                        <input type="text" name="name_without_abbreviation" value="{{ old('name_without_abbreviation', $mfi->name_without_abbreviation) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
            </div>

            <!-- Categories -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-tags text-indigo-600 mr-2"></i>Categories
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach(['t_50', 'cdf', 't_100', 'pksf'] as $field)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ $columnLabels[$field] }}</label>
                            <select name="{{ $field }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Select...</option>
                                <option value="Yes" {{ old($field, $mfi->$field) == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ old($field, $mfi->$field) == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-address-book text-indigo-600 mr-2"></i>Contact Information
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $columnLabels['current_address'] }}</label>
                        <textarea name="current_address" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('current_address', $mfi->current_address) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $columnLabels['phone'] }}</label>
                        <input type="text" name="phone" value="{{ old('phone', $mfi->phone) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $columnLabels['email'] }}</label>
                        <input type="email" name="email" value="{{ old('email', $mfi->email) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $columnLabels['division'] }}</label>
                        <input type="text" name="division" value="{{ old('division', $mfi->division) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $columnLabels['district'] }}</label>
                        <input type="text" name="district" value="{{ old('district', $mfi->district) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $columnLabels['dhaka_area'] }}</label>
                        <select name="dhaka_area" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Select...</option>
                            <option value="Yes" {{ old('dhaka_area', $mfi->dhaka_area) == 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ old('dhaka_area', $mfi->dhaka_area) == 'No' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Operational Data -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-chart-bar text-indigo-600 mr-2"></i>Operational Data
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $columnLabels['no_of_branches'] }}</label>
                        <input type="number" name="no_of_branches" value="{{ old('no_of_branches', $mfi->no_of_branches) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $columnLabels['number_of_employees_total'] }}</label>
                        <input type="number" name="number_of_employees_total" value="{{ old('number_of_employees_total', $mfi->number_of_employees_total) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $columnLabels['number_of_clients_total'] }}</label>
                        <input type="number" name="number_of_clients_total" value="{{ old('number_of_clients_total', $mfi->number_of_clients_total) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $columnLabels['number_of_borrowers_total'] }}</label>
                        <input type="number" name="number_of_borrowers_total" value="{{ old('number_of_borrowers_total', $mfi->number_of_borrowers_total) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
            </div>

            <!-- Financial Information -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-money-bill-wave text-indigo-600 mr-2"></i>Financial Information
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $columnLabels['savings_bdt'] }}</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">৳</span>
                            <input type="number" step="0.01" name="savings_bdt" value="{{ old('savings_bdt', $mfi->savings_bdt) }}"
                                class="w-full border border-gray-300 rounded-lg pl-8 pr-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $columnLabels['loan_disbursement_bdt'] }}</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">৳</span>
                            <input type="number" step="0.01" name="loan_disbursement_bdt" value="{{ old('loan_disbursement_bdt', $mfi->loan_disbursement_bdt) }}"
                                class="w-full border border-gray-300 rounded-lg pl-8 pr-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $columnLabels['loan_outstanding_bdt'] }}</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">৳</span>
                            <input type="number" step="0.01" name="loan_outstanding_bdt" value="{{ old('loan_outstanding_bdt', $mfi->loan_outstanding_bdt) }}"
                                class="w-full border border-gray-300 rounded-lg pl-8 pr-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('mfi.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>Save Changes
                </button>
            </div>
        </div>
    </form>
</div>
@endsection