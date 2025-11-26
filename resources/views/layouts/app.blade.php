<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Inventaris Sekolah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('user.dashboard') }}" class="flex items-center">
                        <svg class="h-8 w-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span class="ml-2 text-xl font-bold text-gray-800">Inventaris Sekolah</span>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('user.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('user.dashboard') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:text-primary-600' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('user.pengajuan.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('user.pengajuan.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:text-primary-600' }}">
                        Pengajuan Saya
                    </a>
                    
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-primary-600 focus:outline-none">
                            <div class="h-8 w-8 rounded-full bg-primary-600 flex items-center justify-center text-white font-medium">
                                {{ substr(Auth::guard('user')->user()->nama, 0, 1) }}
                            </div>
                            <span class="text-sm font-medium">{{ Auth::guard('user')->user()->nama }}</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <div class="px-4 py-2 border-b">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::guard('user')->user()->nama }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::guard('user')->user()->kelas }}</p>
                            </div>
                            <a href="{{ route('user.password.reset.form') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Ganti Password
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button x-data @click="$dispatch('toggle-mobile-menu')" class="text-gray-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-data="{ open: false }" @toggle-mobile-menu.window="open = !open" x-show="open" class="md:hidden bg-white border-t">
            <div class="px-4 py-2 space-y-1">
                <a href="{{ route('user.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('user.dashboard') ? 'bg-primary-50 text-primary-600' : 'text-gray-700' }}">Dashboard</a>
                <a href="{{ route('user.pengajuan.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('user.pengajuan.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700' }}">Pengajuan Saya</a>
                <a href="{{ route('user.password.reset.form') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700">Ganti Password</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-600">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Alerts -->
        @if(session('success'))
            <div class="alert-success mb-6">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error mb-6">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-error mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-gray-500 text-sm">&copy; {{ date('Y') }} Inventaris Sekolah. All rights reserved.</p>
        </div>
    </footer>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>