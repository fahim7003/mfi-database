@extends('layouts.app')

@section('title', 'Deleted Records')
@section('header', 'Deleted MFI Records')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div class="flex items-center justify-between">
        <a href="{{ route('mfi.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-arrow-left mr-2"></i>Back to MFI Data
        </a>
        <span class="text-sm text-gray-500">{{ $mfis->total() }} deleted records</span>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">SL No.</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">License Number</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Name of MFI</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Division</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Deleted At</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($mfis as $mfi)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap">{{ $mfi->sl_no }}</td>
                            <td class="px-4 py-3 whitespace-nowrap font-medium text-indigo-600">{{ $mfi->license_number_of_mfi }}</td>
                            <td class="px-4 py-3">
                                <div class="max-w-xs truncate">{{ $mfi->name_of_mfi }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $mfi->division }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $mfi->deleted_at->format('M d, Y h:i A') }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    <form action="{{ route('mfi.restore', $mfi->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors text-sm">
                                            <i class="fas fa-undo mr-1"></i>Restore
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-trash text-4xl text-gray-300 mb-3"></i>
                                    <p class="text-gray-500 font-medium">No deleted records found</p>
                                    <p class="text-gray-400 text-sm">Deleted records will appear here</p>
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