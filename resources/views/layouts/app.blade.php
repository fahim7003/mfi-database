<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MFI Database') - MFI Management System</title>
   
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
   
    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
   
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   
    <style>
        [x-cloak] { display: none !important; }
       
        .sidebar-link {
            @apply flex items-center w-full px-4 py-3 text-gray-200 hover:bg-slate-700 hover:text-white transition-colors duration-200 rounded-lg;
        }
       
        .sidebar-link.active {
            @apply bg-indigo-600 text-white;
        }
        
        .sidebar-link i {
            flex-shrink: 0;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        /* Table styles */
        .table-container {
            overflow-x: auto;
            max-width: 100%;
        }
    </style>
   
    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen" x-data="{ 
    sidebarOpen: true, 
    sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' || false,
    toggleCollapse() {
        this.sidebarCollapsed = !this.sidebarCollapsed;
        localStorage.setItem('sidebarCollapsed', this.sidebarCollapsed);
    }
}">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-50 bg-slate-800 transform transition-all duration-300 ease-in-out lg:translate-x-0"
            :class="[
                sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
                sidebarCollapsed ? 'w-16' : 'w-64'
            ]"
        >
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center h-16 bg-slate-900 px-4" :class="sidebarCollapsed ? 'justify-center' : 'justify-start'">
                    <button
                        @click="toggleCollapse()"
                        class="text-gray-300 hover:text-white transition-colors p-2 rounded hover:bg-slate-800 flex-shrink-0"
                        :title="sidebarCollapsed ? 'Expand sidebar' : 'Collapse sidebar'"
                    >
                        <i class="fas" :class="sidebarCollapsed ? 'fa-angle-right' : 'fa-angle-left'"></i>
                    </button>
                    <span x-show="!sidebarCollapsed" x-transition class="text-white text-xl font-bold ml-2 truncate whitespace-nowrap overflow-hidden">
                        <i class="fas fa-database mr-2"></i>MFI Database
                    </span>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-2 py-4 space-y-2 overflow-y-auto">
                    <a href="{{ route('dashboard') }}"
                       class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                       :class="sidebarCollapsed ? 'justify-center px-2' : ''"
                       :title="sidebarCollapsed ? 'Dashboard' : ''">
                        <i class="fas fa-home w-6 text-center flex-shrink-0"></i>
                        <span x-show="!sidebarCollapsed" x-transition class="ml-3 whitespace-nowrap">Dashboard</span>
                    </a>
                   
                    <a href="{{ route('mfi.index') }}"
                       class="sidebar-link {{ request()->routeIs('mfi.*') && !request()->routeIs('mfi.trashed') ? 'active' : '' }}"
                       :class="sidebarCollapsed ? 'justify-center px-2' : ''"
                       :title="sidebarCollapsed ? 'MFI Data' : ''">
                        <i class="fas fa-building w-6 text-center flex-shrink-0"></i>
                        <span x-show="!sidebarCollapsed" x-transition class="ml-3 whitespace-nowrap">MFI Data</span>
                    </a>

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('mfi.trashed') }}"
                           class="sidebar-link {{ request()->routeIs('mfi.trashed') ? 'active' : '' }}"
                           :class="sidebarCollapsed ? 'justify-center px-2' : ''"
                           :title="sidebarCollapsed ? 'Deleted Records' : ''">
                            <i class="fas fa-trash-restore w-6 text-center flex-shrink-0"></i>
                            <span x-show="!sidebarCollapsed" x-transition class="ml-3 whitespace-nowrap">Deleted Records</span>
                        </a>
                       
                        <a href="{{ route('users.index') }}"
                           class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                           :class="sidebarCollapsed ? 'justify-center px-2' : ''"
                           :title="sidebarCollapsed ? 'User Management' : ''">
                            <i class="fas fa-users w-6 text-center flex-shrink-0"></i>
                            <span x-show="!sidebarCollapsed" x-transition class="ml-3 whitespace-nowrap">User Management</span>
                        </a>
                    @endif
                </nav>

                <!-- User Info -->
                <div class="p-4 border-t border-gray-700">
                    <div class="flex items-center flex-nowrap" :class="sidebarCollapsed ? 'justify-center' : ''">
                        <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold flex-shrink-0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="ml-3 min-w-0" x-show="!sidebarCollapsed" x-transition>
                            <p class="text-white text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                            <p class="text-gray-400 text-xs capitalize">{{ auth()->user()->role }}</p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="mt-3">
                        @csrf
                        <button 
                            type="submit" 
                            class="w-full px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg transition-colors flex items-center justify-center flex-nowrap"
                            :class="sidebarCollapsed ? 'px-2' : ''"
                            :title="sidebarCollapsed ? 'Logout' : ''"
                        >
                            <i class="fas fa-sign-out-alt flex-shrink-0" :class="sidebarCollapsed ? '' : 'mr-2'"></i>
                            <span x-show="!sidebarCollapsed" x-transition class="whitespace-nowrap">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div 
            class="flex-1 flex flex-col min-w-0 transition-all duration-300"
            :class="sidebarCollapsed ? 'lg:ml-16' : 'lg:ml-64'"
        >
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
                <div class="flex items-center justify-between px-4 py-3">
                    <!-- Mobile menu button -->
                    <button
                        @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100"
                    >
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <div class="flex-1 lg:flex-none">
                        <h1 class="text-xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h1>
                    </div>

                    <div class="flex items-center space-x-4">
                        <span class="hidden sm:inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ auth()->user()->isAdmin() ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                            <i class="fas {{ auth()->user()->isAdmin() ? 'fa-user-shield' : 'fa-user' }} mr-1"></i>
                            {{ ucfirst(auth()->user()->role) }}
                        </span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6 overflow-auto">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                         class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                        <button @click="show = false" class="text-green-700 hover:text-green-900">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                         class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ session('error') }}
                        </div>
                        <button @click="show = false" class="text-red-700 hover:text-red-900">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <span class="font-medium">Please fix the following errors:</span>
                        </div>
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-4 px-6">
                <p class="text-center text-sm text-gray-500">
                    &copy; {{ date('Y') }} MFI Database Management System. All rights reserved.
                </p>
            </footer>
        </div>
    </div>

    <!-- Overlay for mobile sidebar -->
    <div
        x-show="sidebarOpen"
        @click="sidebarOpen = false"
        class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
        x-cloak
    ></div>

    @stack('scripts')
</body>
</html>