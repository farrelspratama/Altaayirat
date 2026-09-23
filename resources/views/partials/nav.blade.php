<nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
    <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
        
        <a href="{{ route('schedules.search') }}" class="text-lg font-bold text-sky-600 hover:text-sky-700 transition">
            Altaayirat
        </a>

        
        <div class="flex items-center gap-4 text-sm">
            @auth
                
                @if (Auth::user()->role === 'staff')
                    <a href="{{ route('payments.index') }}" class="text-slate-600 hover:text-sky-600 font-medium transition">
                        Konfirmasi Pembayaran
                    </a>
                @endif

                <span class="text-slate-600">
                    Halo, <span class="font-medium text-slate-800">{{ Auth::user()->name }}</span>
                </span>

                <form action="{{ route('auth.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-700 font-medium cursor-pointer transition">
                        Logout
                    </button>
                </form>
            @endauth

            @guest
                <a href="{{ route('auth.login.form') }}" class="text-slate-600 hover:text-sky-600 font-medium transition">
                    Login
                </a>
                <a href="{{ route('auth.register.form') }}" class="bg-sky-600 text-white px-3 py-1.5 rounded-md hover:bg-sky-700 font-medium transition shadow-sm">
                    Daftar
                </a>
            @endguest
        </div>
    </div>
</nav>