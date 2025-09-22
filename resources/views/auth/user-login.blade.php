<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa - Inventaris Sekolah</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container-login">
        <h3 class="title-login">Login Siswa</h3>

            @if($errors->any())
             <div class="alert alert-danger">
            @foreach($errors->all() as $error)
             <div>{{ $error }}</div>
            @endforeach
             </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">
            {{ session('error') }}
            </div>
            @endif

            {{-- Login Form --}}
            <form method="POST" action="{{ url('/login') }}">
                @csrf
                <div class="form-user">
                <label for="nisn" class="form-label">NISN</label>
                <input type="text" class="form-control" 
                    id="nisn" 
                    name="nisn" 
                    value="{{ old('nisn') }}" required autofocus>
                </div>

                <div class="form-user">
                <label for="password" class="form-label">Password</label>
                <input type="password" 
                    class="form-control" 
                    id="password" 
                    name="password" required>
                </div>

                <button type="submit" class="btn-submit">Login</button>
            </form>

            <div class="text-center">
                <a href="" class="regiter-user">Belum punya akun? Daftar!</a>
            </div>
    </div>
        <a href="{{ url('/admin/login') }}" class="user-section">
            <svg width="24" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M16 5L9 12L16 19" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>Login Admin</a>      
</body>
</html>
