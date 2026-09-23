<nav style="padding: 10px; border-bottom: 1px solid #ccc; margin-bottom: 20px;">
    {{-- Menu Utama --}}
    <a href="{{ route('schedules.search') }}">Cari Penerbangan</a>

    {{-- Tampil jika pengguna SUDAH login --}}
    @auth
        | Halo, <strong>{{ Auth::user()->name }}</strong>

        {{-- Form Logout dengan method POST dan proteksi CSRF --}}
        <form action="{{ route('auth.logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" style="background: none; border: none; color: blue; text-decoration: underline; cursor: pointer; padding: 0;">
                Logout
            </button>
        </form>
    @endauth

    {{-- Tampil jika pengguna BELUM login (tamu) --}}
    @guest
        | <a href="{{ route('auth.login.form') }}">Login</a>
        | <a href="{{ route('auth.register.form') }}">Daftar</a>
    @endguest
</nav>