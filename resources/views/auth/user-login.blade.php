<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa - Inventaris Sekolah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
    
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            {{-- Login Card --}}
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                {{-- Header --}}
                <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-8 py-10 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-2xl mb-4">
                        <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white">Inventaris Sekolah</h1>
                    <p class="text-primary-100 mt-2">Portal Siswa</p>
                </div>

                {{-- Form --}}
                <div class="p-8">
                    {{-- Error Messages --}}
                    @if($errors->any())
                        <div class="alert alert-error mb-6">
                            <div class="flex items-start">
                                <svg class="h-5 w-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div class="text-sm">
                                    @foreach($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        {{-- NISN --}}
                        <div>
                            <label for="nisn" class="label">NISN</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <input type="text" 
                                       id="nisn" 
                                       name="nisn" 
                                       value="{{ old('nisn') }}"
                                       class="input-field pl-10 @error('nisn') input-error @enderror" 
                                       placeholder="Masukkan NISN Anda"
                                       required 
                                       autofocus>
                            </div>
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password" class="label">Password</label>
                            <div class="relative" x-data="{ showPassword: false }">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input :type="showPassword ? 'text' : 'password'" 
                                       id="password" 
                                       name="password" 
                                       class="input-field pl-10 pr-10 @error('password') input-error @enderror" 
                                       placeholder="Masukkan password"
                                       required>
                                <button type="button" 
                                        @click="showPassword = !showPassword"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                    <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg x-show="showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit" class="w-full btn-primary btn-lg">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Masuk
                        </button>
                    </form>

                    {{-- Divider --}}
                    <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                        <p class="text-sm text-gray-600">
                            Admin atau Staff? 
                            <a href="{{ route('admin.login') }}" class="font-medium text-primary-600 hover:text-primary-700">
                                Login di sini
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <p class="text-center mt-6 text-white/80 text-sm">
                &copy; {{ date('Y') }} Inventaris Sekolah. All rights reserved.
            </p>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>