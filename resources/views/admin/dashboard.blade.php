@extends('layouts.admin')

@section('content')
  <dashboard-page
    :admin='@json(Auth::guard("admin")->user())'
    :stats='@json($stats)'
    :pengajuan-terbaru='@json($pengajuan_terbaru)'
    :barang-stok-rendah='@json($barang_stok_rendah)'
  ></dashboard-page>
@endsection