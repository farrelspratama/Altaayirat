<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Altaayirat')</title>
</head>
<body style="font-family: sans-serif; margin: 20px; line-height: 1.5;">

    {{-- Navigasi global untuk seluruh halaman --}}
    @include('partials.nav')

    {{-- Flash message global jika ada session status --}}
    @if (session('status'))
        <p style="color: green; background: #e8f5e9; padding: 10px; border-radius: 4px;">
            {{ session('status') }}
        </p>
    @endif

    {{-- Slot konten dinamis yang akan diisi oleh masing-masing view --}}
    @yield('content')

</body>
</html>