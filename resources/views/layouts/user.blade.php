<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Inventaris Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- ✅ Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* 🌐 Gunakan font Poppins di seluruh halaman */
        html, body {
            margin: 0;
            padding: 0;
            background-color: #a7d2ff;
            font-family: 'Poppins', sans-serif !important;
        }

        * {
            font-family: 'Poppins', sans-serif !important;
        }

        .navbar-custom {
            margin-bottom: 0 !important;
            background-color: #7D94AB;
            padding: 1rem 0;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar-custom .navbar-brand {
            font-size: 1.4rem;
            font-weight: 700;
            color: #fff !important;
        }

        .navbar-custom .nav-link {
            font-size: 1.05rem;
            font-weight: 500;
            color: #f0f8ff !important;
            transition: color 0.2s ease;
        }

        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: #fff !important;
            text-decoration: underline;
        }

        .navbar-custom .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            font-size: 0.95rem;
        }

        .navbar-custom .dropdown-item:hover {
            background-color: #eaf4ff;
        }

        .navbar-custom .bi {
            font-size: 1.3rem;
            vertical-align: middle;
        }

        .container-fluid {
            padding: 0 !important;
        }

        /* 🔔 Alert styling agar tetap rapi dengan Poppins */
        .alert {
            font-size: 0.95rem;
            border-radius: 10px;
        }

        .btn-close {
            outline: none !important;
            box-shadow: none !important;
        }
    </style>
</head>
<body class="bg-light" style="margin:0; padding:0;">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('user.dashboard') }}">
                <i class="bi bi-backpack2 me-1"></i> Portal Siswa
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.pengajuan.index') }}">Pengajuan Saya</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.pengajuan.create') }}">Ajukan Barang</a>
                    </li>
                </ul>
                
                <div class="navbar-nav">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person"></i> {{ Auth::guard('user')->user()->nama }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <span class="dropdown-item-text">NISN: {{ Auth::guard('user')->user()->nisn }}</span>
                            </li>
                            <li>
                                <span class="dropdown-item-text">Kelas: {{ Auth::guard('user')->user()->kelas }}</span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid p-0">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div id="app" class="p-0 m-0">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    @vite('resources/js/app.js')
</body>
</html>
