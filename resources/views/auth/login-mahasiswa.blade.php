<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Mahasiswa - Universitas</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="logo">
            <img src="{{ asset('images/logo-universitas.png') }}" alt="Logo Universitas">
        </div>

        <h1>Login Mahasiswa</h1>
        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <input type="hidden" name="role" value="mahasiswa">
            
            <div class="form-group">
                <label for="email">Email / No Hp</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="Masukkan email / no hp">
            </div>

            <div class="form-group">
                <label for="password">NIM</label>
                <input type="password" id="password" name="password" required placeholder="Masukkan NIM">
            </div>

            <button type="submit" class="btn">Login</button>
        </form>
        <a href="{{ url('/') }}" class="back-link">← Kembali ke Beranda</a>
    </div>
</body>
</html>