<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Siswa - Inventaris Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('user.dashboard') }}">Inventaris Sekolah</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a href="{{ route('user.dashboard') }}" class="nav-link">Dashboard</a></li>
                    <li class="nav-item"><a href="{{ route('user.pengajuan.index') }}" class="nav-link">Pengajuan</a></li>
                </ul>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>
</body>
</html>
