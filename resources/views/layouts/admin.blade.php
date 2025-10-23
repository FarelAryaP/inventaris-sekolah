<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventaris Sekolah</title>   
    @vite('resources/js/app.js')
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

      <main>
        @yield('content')
      </main>
   </div>

   <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">
       @csrf
   </form>


</body>
</html>