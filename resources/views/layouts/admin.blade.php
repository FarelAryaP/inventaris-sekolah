<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventaris Sekolah</title>
  
</head>
<body>
   <div id="app">
<sidebar-component
  dashboard-url="{{ route('admin.dashboard') }}"
  barang-url="{{ route('admin.barang.index') }}"
  pengajuan-url="{{ route('admin.pengajuan.index') }}"
  peminjaman-url="{{ route('admin.peminjaman.index') }}"
  laporan-url="{{ route('admin.laporan.peminjaman') }}"
  :user='@json(Auth::guard("admin")->user())'>
</sidebar-component>

</div>
    <main>
    @yield('content')
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">
    @csrf
    </form>
    </main>
    @vite('resources/js/app.js')
</body>
</html>