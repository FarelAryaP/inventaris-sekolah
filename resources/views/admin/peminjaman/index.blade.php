@extends('layouts.admin')

@section('content')
  <peminjaman-page
    peminjamans-json='@json($peminjamans)'
    laporan-url="{{ route('admin.laporan.peminjaman') }}"
    csrf="{{ csrf_token() }}"
  ></peminjaman-page>
@endsection
