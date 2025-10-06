<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Siswa</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body>
    <div id="app">
        <!-- Oper data user dari backend ke Vue lewat props -->
        <dashboard-layout :user='@json(auth()->user())'>
            <template #default>
                <h1>Selamat datang, {{ auth()->user()->nama }}</h1>
                <p>Ini adalah halaman dashboard siswa.</p>
            </template>
        </dashboard-layout>
    </div>
</body>
</html>