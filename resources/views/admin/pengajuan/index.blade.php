@extends('layouts.admin')

@section('content')
  <pengajuan-page
    :admin='@json(Auth::guard("admin")->user())'
    :pengajuans='@json($pengajuans)'
    csrf="{{ csrf_token() }}"
  ></pengajuan-page>
@endsection
