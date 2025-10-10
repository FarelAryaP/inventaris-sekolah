@extends('layouts.user')

@section('title', 'Pengajuan Saya')

@section('content')
<div id="app">
    <pengajuan-saya 
        :pengajuans='@json($pengajuans->items())'
        create-url="{{ route('user.pengajuan.create') }}" 
        dashboard-url="{{ route('user.dashboard') }}"
        prev-url="{{ $pengajuans->previousPageUrl() }}"
        next-url="{{ $pengajuans->nextPageUrl() }}"
        current-page="{{ $pengajuans->currentPage() }}"
        last-page="{{ $pengajuans->lastPage() }}"
    />
</div>
@endsection
