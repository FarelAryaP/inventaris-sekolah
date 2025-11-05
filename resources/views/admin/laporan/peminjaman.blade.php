<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan Peminjaman</title>
    @vite('resources/js/app.js')
</head>
<body>
    @extends('layouts.admin')

@section('title', 'Laporan Peminjaman')

@section('content')
<div id="app">
    <laporan-page :data-peminjamans='@json($peminjamans)'></laporan-page>
</div>
@endsection
</body>
</html>
