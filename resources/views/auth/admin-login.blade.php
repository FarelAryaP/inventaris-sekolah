<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    @vite('resources/js/app.js')
</head>
<body>
    <div id="app">
        <login-admin></login-admin>
    </div>
</body>
</html>
