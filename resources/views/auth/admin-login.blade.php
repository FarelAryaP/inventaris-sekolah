<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Inventaris Sekolah</title>
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
</head>
<body>
    <div class="container-login">
        <h3 class="title-login">Login Admin</h3>

            @if($errors->any())
             <div class="alert alert-danger">
            @foreach($errors->all() as $error)
             <div>{{ $error }}</div>
            @endforeach
             </div>
            @endif

            <form method="POST" action="{{ url('/admin/login') }}">
                @csrf
                <div class="form-user">
                <label for="username" class="form-label">Username</label>                                
                <input type="text" class="form-control" 
                    id="username" 
                    name="username"  
                    value="{{ old('username') }}" required>
                </div>

                <div class="form-user">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" 
                    id="password"
                    name="password" required>
                </div>

                <button type="submit" class="btn-submit">Login</button>
            </form>
    </div>
    <a href="{{ url('/login') }}" class="user-section">
        <svg width="24" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M16 5L9 12L16 19" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>Login Siswa</a>
</body>
</html>