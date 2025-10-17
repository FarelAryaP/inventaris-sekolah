<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Inventaris Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <!-- NAVIGATION BAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <!-- Brand -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-box-seam me-2"></i> 
                Inventaris Sekolah
            </a>
            
            <!-- Toggler for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navigation Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                           href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    
                    <!-- Barang -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.barang.*') ? 'active' : '' }}" 
                           href="{{ route('admin.barang.index') }}">
                            <i class="bi bi-box-seam"></i> Barang
                        </a>
                    </li>
                    
                    <!-- Pengajuan -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.pengajuan.*') ? 'active' : '' }}" 
                           href="{{ route('admin.pengajuan.index') }}">
                            <i class="bi bi-file-earmark-text"></i> Pengajuan
                            
                        </a>
                    </li>
                    
                    <!-- Peminjaman -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}" 
                           href="{{ route('admin.peminjaman.index') }}">
                            <i class="bi bi-arrow-repeat"></i> Peminjaman
                        </a>
                    </li>
                    
                    <!-- Laporan -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}" 
                           href="{{ route('admin.laporan.peminjaman') }}">
                            <i class="bi bi-file-earmark-bar-graph"></i> Laporan
                        </a>
                    </li>
                    
                    <!-- SUPER ADMIN ONLY MENU -->
                    @if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->id_role == 1)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.admin-management.*') ? 'active' : '' }}" 
                               href="#" 
                               role="button" 
                               data-bs-toggle="dropdown"
                               aria-expanded="false">
                                <i class="bi bi-shield-check"></i> Management
                                <span class="badge bg-warning text-dark ms-1">SUPER</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <h6 class="dropdown-header">
                                        <i class="bi bi-shield-lock"></i> Super Admin Tools
                                    </h6>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                                       href="{{ route('admin.users.index') }}">
                                        <i class="bi bi-people"></i> Kelola Siswa
                                        <span class="badge bg-success float-end">
                                            {{ \App\Models\User::count() }}
                                        </span>
                                    </a>
                                </li>
                                
                            </ul>
                        </li>
                    @endif
                </ul>
                
                <!-- User Profile Dropdown -->
                <div class="navbar-nav">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" 
                           href="#" 
                           role="button" 
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="bi bi-person-circle"></i> 
                            {{ Auth::guard('admin')->user()->nama }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <h6 class="dropdown-header">
                                    <i class="bi bi-person-badge"></i> Admin Profile
                                </h6>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <span class="dropdown-item-text">
                                    <strong>Username:</strong> {{ Auth::guard('admin')->user()->username }}
                                </span>
                            </li>
                            <li>
                                <span class="dropdown-item-text">
                                    <strong>Role:</strong> 
                                    @if(Auth::guard('admin')->user()->id_role == 1)
                                        <span class="badge bg-warning text-dark">
                                            {{ Auth::guard('admin')->user()->role->nama }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            {{ Auth::guard('admin')->user()->role->nama }}
                                        </span>
                                    @endif
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
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

    <!-- MAIN CONTENT -->
    <div class="container-fluid" style="margin-top: 70px;">
        <div class="row">
            <main class="col-md-12 ms-sm-auto px-md-4">
                
                <!-- ALERTS -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <i class="bi bi-check-circle-fill"></i>
                        <strong>Berhasil!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <i class="bi bi-exclamation-octagon-fill"></i>
                        <strong>Validation Error!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- PAGE CONTENT -->
                <div class="py-4">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="footer mt-5 py-3 bg-light border-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 ">
                    <span class="text-muted">
                        <p class="bi bi-c-circle text-center"> 2025 Inventaris Sekolah. All rights reserved.
                        </p>
                        </span>
                </div>
            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>