<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Perpustakaan Digital')</title>

    @vite('resources/css/app.css')
</head>

<body>

    <header class="site-header">
        <div class="container">
            <h1>📚 Perpustakaan Digital</h1>
            <p>Tempat menemukan berbagai koleksi buku</p>
        </div>
    </header>

    <nav class="navbar">
        <div class="container nav-container">

            <a href="{{ route('home') }}" class="brand">
                Perpustakaan
            </a>

            <div class="nav-links">
                <a href="{{ route('home') }}">
                    Beranda
                </a>

                <a href="{{ route('buku.index') }}">
                    Daftar Buku
                </a>
            </div>

        </div>
    </nav>

    <main class="content">
        <div class="container">

            @yield('content')

        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>
                &copy; {{ date('Y') }} Perpustakaan Digital
            </p>
        </div>
    </footer>

</body>
</html>