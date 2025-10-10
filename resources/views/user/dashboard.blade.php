@extends('layouts.user')

@section('content')
<div id="app">
  <dashboard
    :user='@json($user)'
    :stats='@json($stats)'
    :pengajuan_terbaru='@json($pengajuan_terbaru)'
    :barang_tersedia='@json($barang_tersedia)'
    :routes='@json([
    "pengajuanIndex" => route("user.pengajuan.index"),
    "pengajuanCreate" => route("user.pengajuan.create"),
    "pengajuanShow" => "/pengajuan/:id"
])'

  />
</div>

@endsection
