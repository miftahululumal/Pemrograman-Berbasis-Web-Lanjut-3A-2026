
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Perpustakaan Digital')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: #f4f7f5;
            margin: 0;
            overflow-x: hidden;
        }

        /* ================= SIDEBAR ================= */

        .sidebar {
            width: 76px;
            height: 100vh;
            background: #1b4332;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            overflow-x: hidden;
            overflow-y: auto;
            white-space: nowrap;

            transition:
                width .4s cubic-bezier(.22, 1, .36, 1),
                box-shadow .4s ease;
        }

        .sidebar:hover {
            width: 255px;
            box-shadow: 8px 0 25px rgba(0, 0, 0, .13);
        }

        /* ================= BRAND ================= */

        .sidebar-brand {
            height: 75px;
            padding: 0 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 18px;
            font-weight: 700;
            overflow: hidden;
            border-bottom: 1px solid rgba(255,255,255,.10);
        }

        .sidebar-brand i {
            min-width: 28px;
            font-size: 25px;
            text-align: center;
        }

        .sidebar-brand span {
            opacity: 1;
            transition: opacity .2s ease;
        }

        /* ================= LABEL MENU ================= */

        .sidebar-label {
            padding: 22px 20px 8px;
            font-size: 11px;
            color: #b7d5c5;
            font-weight: 700;
            letter-spacing: 1px;
            overflow: hidden;
            transition: opacity .2s ease;
        }

        /* ================= LINK MENU ================= */

        .sidebar a {
            height: 48px;
            margin: 4px 8px;
            padding: 0 20px;

            display: flex;
            align-items: center;
            gap: 12px;

            border-radius: 9px;
            color: #e5f3eb;
            text-decoration: none;
            overflow: hidden;

            transition:
                background .25s ease,
                color .25s ease,
                padding .4s cubic-bezier(.22, 1, .36, 1);
        }

        .sidebar a i {
            min-width: 28px;
            font-size: 20px;
            text-align: center;
        }

        .sidebar a span {
            opacity: 1;
            transition: opacity .2s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #2d6a4f;
            color: white;
        }

        /* ================= MODE MINI ================= */

        .sidebar:not(:hover) .sidebar-brand {
            padding: 0;
            justify-content: center;
        }

        .sidebar:not(:hover) .sidebar-brand span,
        .sidebar:not(:hover) a span,
        .sidebar:not(:hover) .sidebar-logout span {
            display: none;
        }

        .sidebar:not(:hover) .sidebar-label {
            height: 0;
            padding: 0;
            margin: 0;
            opacity: 0;
            visibility: hidden;
        }

        .sidebar:not(:hover) a {
            justify-content: center;
            padding: 0;
            margin: 5px 10px;
        }

        .sidebar:not(:hover) a i {
            margin: 0;
        }

        /* ================= LOGOUT ================= */

        .sidebar-logout {
            width: calc(100% - 16px);
            height: 48px;
            margin: 12px 8px 20px;
            padding: 0 20px;

            border: none;
            border-radius: 9px;
            background: #2d6a4f;
            color: white;

            display: flex;
            align-items: center;
            gap: 12px;

            overflow: hidden;
            cursor: pointer;

            transition:
                background .25s ease,
                padding .4s cubic-bezier(.22, 1, .36, 1);
        }

        .sidebar-logout i {
            min-width: 28px;
            font-size: 20px;
            text-align: center;
        }

        .sidebar-logout:hover {
            background: #40916c;
        }

        .sidebar:not(:hover) .sidebar-logout {
            justify-content: center;
            padding: 0;
        }

        .sidebar:not(:hover) .sidebar-logout span {
            display: none;
        }

        /* ================= KONTEN UTAMA ================= */

        .main-content {
            margin-left: 76px;
            width: calc(100% - 76px);
            min-height: 100vh;

            transition:
                margin-left .4s cubic-bezier(.22, 1, .36, 1),
                width .4s cubic-bezier(.22, 1, .36, 1);
        }

        body:has(.sidebar:hover) .main-content {
            margin-left: 255px;
            width: calc(100% - 255px);
        }

        /* ================= TOPBAR ================= */

        .topbar {
            background: white;
            padding: 17px 28px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            box-shadow: 0 2px 8px rgba(0,0,0,.05);

            position: sticky;
            top: 0;
            z-index: 900;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .toggle-sidebar {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 8px;
            background: #e8f5ed;
            color: #1b4332;
            font-size: 23px;

            display: none;
            align-items: center;
            justify-content: center;

            cursor: pointer;
        }

        .content-area {
            padding: 28px;
            width: 100%;
        }

        .sidebar-overlay {
            display: none;
        }

        /* ================= RESPONSIVE HP ================= */

        @media (max-width: 768px) {

            .sidebar {
                width: 255px;
                transform: translateX(-100%);
                transition: transform .35s ease;
                box-shadow: 5px 0 20px rgba(0,0,0,.15);
            }

            .sidebar:hover {
                width: 255px;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            /* Di HP, tulisan selalu terlihat saat sidebar dibuka */

            .sidebar:not(:hover) .sidebar-brand {
                padding: 0 24px;
                justify-content: flex-start;
            }

            .sidebar:not(:hover) .sidebar-brand span,
            .sidebar:not(:hover) a span,
            .sidebar:not(:hover) .sidebar-logout span {
                display: inline;
            }

            .sidebar:not(:hover) .sidebar-label {
                height: auto;
                padding: 22px 20px 8px;
                opacity: 1;
                visibility: visible;
            }

            .sidebar:not(:hover) a {
                justify-content: flex-start;
                padding: 0 20px;
                margin: 4px 8px;
            }

            .sidebar:not(:hover) .sidebar-logout {
                justify-content: flex-start;
                padding: 0 20px;
            }

            .main-content,
            body:has(.sidebar:hover) .main-content {
                margin-left: 0;
                width: 100%;
            }

            .toggle-sidebar {
                display: flex;
            }

            .topbar {
                padding: 12px 15px;
            }

            .content-area {
                padding: 15px;
            }

            .sidebar-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.4);
                z-index: 999;
            }
        }
    </style>
</head>

<body>

@auth

    {{-- SIDEBAR --}}
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-brand">
            <i class="bi bi-book-half"></i>
            <span>PERPUSTAKAAN</span>
        </div>

        {{-- MENU UTAMA --}}
        <div class="sidebar-label">MENU UTAMA</div>

        <a href="{{ route('dashboard') }}"
           class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
        </a>

        @can('Lihat daftar buku')
            <a href="{{ route('buku.index') }}"
               class="{{ request()->routeIs('buku.index', 'buku.show') ? 'active' : '' }}">
                <i class="bi bi-book"></i>
                <span>Daftar Buku</span>
            </a>
        @endcan

        {{-- MANAJEMEN --}}
        @can('Kelola data pengguna')
            <div class="sidebar-label">MANAJEMEN</div>

            <a href="{{ route('pengguna.index') }}"
               class="{{ request()->routeIs('pengguna.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Kelola Pengguna</span>
            </a>
        @endcan

        @can('Kelola role pengguna')
            <a href="{{ route('role.index') }}"
               class="{{ request()->routeIs('role.*') ? 'active' : '' }}">
                <i class="bi bi-shield-lock"></i>
                <span>Kelola Role</span>
            </a>
        @endcan

        {{-- TRANSAKSI --}}
        @can('Kelola peminjaman')
            <div class="sidebar-label">TRANSAKSI</div>

            <a href="{{ route('peminjaman.index') }}"
               class="{{ request()->routeIs('peminjaman.index') ? 'active' : '' }}">
                <i class="bi bi-journal-arrow-down"></i>
                <span>Peminjaman</span>
            </a>
        @endcan

        @can('Kelola pengembalian')
            @unless(auth()->user()->can('Kelola peminjaman'))
                <div class="sidebar-label">TRANSAKSI</div>
            @endunless

            <a href="{{ route('pengembalian.index') }}"
               class="{{ request()->routeIs('pengembalian.index') ? 'active' : '' }}">
                <i class="bi bi-journal-check"></i>
                <span>Pengembalian</span>
            </a>

            <a href="{{ route('peminjaman.riwayat') }}"
               class="{{ request()->routeIs('peminjaman.riwayat') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Riwayat Peminjaman</span>
            </a>
        @endcan

        {{-- LAPORAN --}}
        @can('Lihat laporan perpustakaan')
            <div class="sidebar-label">LAPORAN</div>

            <a href="{{ route('laporan.index') }}"
               class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart"></i>
                <span>Laporan Perpustakaan</span>
            </a>
        @endcan

        {{-- MENU SISWA --}}
        @if(auth()->user()->hasRole('siswa'))

            <div class="sidebar-label">MENU SISWA</div>

            @can('Mengajukan peminjaman buku')
                <a href="{{ route('peminjaman.create') }}"
                   class="{{ request()->routeIs('peminjaman.create') ? 'active' : '' }}">
                    <i class="bi bi-send"></i>
                    <span>Ajukan Peminjaman</span>
                </a>
            @endcan

            @can('Melihat status peminjaman sendiri')
                <a href="{{ route('peminjaman.index') }}"
                   class="{{ request()->routeIs('peminjaman.index') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i>
                    <span>Status Peminjaman</span>
                </a>
            @endcan

        @endif

        {{-- AKUN --}}
        <div class="sidebar-label">AKUN</div>

        <a href="{{ route('profile.edit') }}"
           class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i>
            <span>Profil Saya</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="sidebar-logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>

    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

@endauth

{{-- KONTEN UTAMA --}}
<div class="main-content">

    @auth
        <div class="topbar">

            <div class="topbar-left">

                <button type="button"
                        class="toggle-sidebar"
                        id="toggleSidebar"
                        aria-label="Buka atau tutup sidebar">
                    <i class="bi bi-list"></i>
                </button>

                <strong>@yield('page-title', 'Dashboard')</strong>

            </div>

            <span class="text-secondary">
                <i class="bi bi-person-circle"></i>
                {{ Auth::user()->name }}
            </span>

        </div>
    @endauth

    @isset($header)
        <div class="bg-white px-4 py-3 shadow-sm">
            {{ $header }}
        </div>
    @endisset

    <main class="content-area">

        @if (isset($slot))
            {{ $slot }}
        @else
            @yield('content')
        @endif

    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const sidebar = document.getElementById('sidebar');
        const toggleButton = document.getElementById('toggleSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        if (!sidebar || !toggleButton) {
            return;
        }

        toggleButton.addEventListener('click', function () {
            sidebar.classList.toggle('show');

            if (overlay) {
                overlay.classList.toggle('show');
            }
        });

        if (overlay) {
            overlay.addEventListener('click', function () {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        }

    });
</script>

</body>
</html>
