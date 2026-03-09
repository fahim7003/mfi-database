@extends('layouts.app')

@section('title', 'User Management')
@section('header', 'User Management')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <p class="text-gray-600">Manage user accounts and passwords</p>
        <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
            <i class="fas fa-user-plus mr-2"></i>Add New User
        </a>
    </div>

    <!-- Users Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($users as $user)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ showPasswordForm: false }">
                <!-- User Header -->
                <div class="p-6 {{ $user->isAdmin() ? 'bg-gradient-to-r from-red-500 to-pink-500' : 'bg-gradient-to-r from-blue-500 to-indigo-500' }} text-white">
                    <div class="flex items-center">
                        <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center text-2xl font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl font-bold">{{ $user->name }}</h3>
                            <p class="text-white/80">{{ '@' . $user->username }}</p>
                        </div>
                    </div>
                </div>

                <!-- User Details -->
                <div class="p-6">
                    <div class="space-y-3">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-envelope w-6 text-gray-400"></i>
                            <span>{{ $user->email ?? 'No email' }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-user-tag w-6 text-gray-400"></i>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->isAdmin() ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                        <div class="flex items-center text-gray-600 text-sm">
                            <i class="fas fa-calendar w-6 text-gray-400"></i>
                            <span>Joined {{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <button @click="showPasswordForm = !showPasswordForm"
                            class="w-full px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors flex items-center justify-center">
                            <i class="fas fa-key mr-2"></i>Change Password
                        </button>

                        <!-- Password Change Form -->
                        <div x-show="showPasswordForm" x-collapse class="mt-4">
                            <form action="{{ route('users.password', $user) }}" method="POST" class="space-y-3">
                                @csrf
                                @method('PUT')
                                <div>
                                    <input type="password" name="password" placeholder="New Password" required
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div class="flex gap-2">
                                    <button type="submit" class="flex-1 px-3 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 transition-colors">
                                        Update
                                    </button>
                                    <button type="button" @click="showPasswordForm = false" class="px-3 py-2 bg-gray-200 text-gray-700 text-sm rounded-lg hover:bg-gray-300 transition-colors">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>

                        @if($user->id !== auth()->id())
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="mt-2"
                                onsubmit="return confirm('Are you sure you want to delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors flex items-center justify-center">
                                    <i class="fas fa-trash mr-2"></i>Delete User
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
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
</style>
@endpush