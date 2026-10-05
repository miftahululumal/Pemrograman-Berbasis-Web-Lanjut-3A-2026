@extends('layouts.app')

@section('title', 'Beranda - Perpustakaan')

@section('content')

    <section class="hero">
        <div class="hero-content">

            <span class="badge">
                SELAMAT DATANG
            </span>

            <h2>
                Selamat Datang di Perpustakaan Digital
            </h2>

            <p>
                Temukan berbagai koleksi buku untuk menambah
                wawasan, pengetahuan, dan keterampilanmu.
            </p>

            <a href="{{ route('buku.index') }}" class="btn">
                Lihat Daftar Buku
            </a>

        </div>
    </section>

    <section class="info-section">

        <h2>Tentang Perpustakaan</h2>

        <div class="info-grid">

            <div class="info-card">
                <span class="icon">📖</span>

                <h3>
                    Koleksi Buku
                </h3>

                <p>
                    Berbagai buku tersedia untuk membantu
                    proses belajar.
                </p>
            </div>

            <div class="info-card">
                <span class="icon">💻</span>

                <h3>
                    Mudah Diakses
                </h3>

                <p>
                    Jelajahi daftar buku dengan tampilan
                    yang sederhana.
                </p>
            </div>

            <div class="info-card">
                <span class="icon">🎓</span>

                <h3>
                    Untuk Belajar
                </h3>

                <p>
                    Temukan referensi untuk mendukung
                    kegiatan akademik.
                </p>
            </div>

        </div>

    </section>

@endsection