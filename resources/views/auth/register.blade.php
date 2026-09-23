<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar - Altaayirat</title>
</head>
<body>
    <h1>Daftar Akun</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('auth.register') }}" method="POST">
        {{-- @csrf WAJIB ada di SETIAP form yang method-nya bukan GET.
             Ini generate token tersembunyi yang dicocokkan Laravel saat
             form disubmit, mencegah serangan CSRF - proteksi yang
             SAMA SEKALI TIDAK ADA di project PHP native versi lama. --}}
        @csrf

        <label for="name">Nama:</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <label for="password_confirmation">Ulangi Password:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>

        <button type="submit">Daftar</button>
    </form>

    <p>Sudah punya akun? <a href="{{ route('auth.login.form') }}">Login di sini</a></p>
</body>
</html>
