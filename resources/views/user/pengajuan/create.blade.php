@extends('layouts.user')

@section('title', 'Ajukan Barang')

@section('content')
<div id="app">
  <pengajuan-create
    :barangs='@json($barangs)'
    :routes='@json([
      "index" => route("user.pengajuan.index"),
      "store" => route("user.pengajuan.store")
    ])'
    csrf="{{ csrf_token() }}"
  ></pengajuan-create>
</div>
@endsection
