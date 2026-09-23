<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Altaayirat</title>
</head>
<body>
    <h1>Login</h1>

    @if (session('status'))
        <div style="color: green;">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('auth.login') }}" method="POST">
        @csrf

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Login</button>
    </form>

    <p>Belum punya akun? <a href="{{ route('auth.register.form') }}">Daftar di sini</a></p>
</body>
</html>
