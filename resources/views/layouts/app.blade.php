<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Al-Taayirat') — Al-Taayirat</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-canvas text-stone-800 font-sans antialiased">

    @include('partials.nav')

    {{-- Halaman biasa memakai kontainer sempit ini. Halaman yang butuh
         lebar penuh (seperti home) menimpanya: @section('main_class', '') --}}
    <main class="flex-1 @yield('main_class', 'max-w-5xl w-full mx-auto px-4 py-10')">
        @yield('content')
    </main>

    <footer class="border-t border-stone-200 py-6 text-center text-sm text-stone-500">
        &copy; {{ date('Y') }} Al-Taayirat.com
    </footer>

</body>
</html>