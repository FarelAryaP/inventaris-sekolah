<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Inventaris Sekolah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-800 to-gray-900 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gray-800 text-white p-8 text-center">
                <svg class="h-16 w-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <h1 class="text-2xl font-bold">Admin Panel</h1>
                <p class="text-gray-300 mt-2">Inventaris Sekolah</p>
            </div>

            <!-- Form -->
            <div class="p-8">
                @if(session('error'))
                    <div class="alert-error mb-4 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert-error mb-4 text-sm">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf

                    <!-- Username -->
                    <div class="mb-6">
                        <label for="username" class="label">Username</label>
                        <input type="text" 
                               id="username" 
                               name="username" 
                               value="{{ old('username') }}"
                               class="input-field @error('username') input-error @enderror" 
                               placeholder="Masukkan username"
                               required 
                               autofocus>
                        @error('username')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label for="password" class="label">Password</label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="input-field @error('password') input-error @enderror" 
                               placeholder="Masukkan password"
                               required>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-gray-800 hover:bg-gray-900 text-white font-medium py-3 px-4 rounded-lg transition duration-200">
                        Login
                    </button>
                </form>

                <!-- Divider -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Siswa? 
                        <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                            Login di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Info -->
        <div class="text-center mt-6 text-gray-400 text-sm">
            <p>&copy; {{ date('Y') }} Inventaris Sekolah. All rights reserved.</p>
        </div>
    </div>
</body>
</html>