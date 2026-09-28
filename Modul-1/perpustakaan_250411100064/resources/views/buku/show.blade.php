@extends('layouts.app')

@section('title', 'Detail Buku - Perpustakaan')

@section('content')

    @if ($dataBuku)

        <div class="detail-container">

            <div class="detail-cover">
                <img
                    src="{{ $dataBuku['cover'] }}"
                    alt="Cover {{ $dataBuku['judul'] }}"
                >
            </div>

            <div class="detail-content">

                <span class="book-category">
                    {{ $dataBuku['kategori'] }}
                </span>

                <h2>{{ $dataBuku['judul'] }}</h2>

                <div class="detail-info">

                    <p>
                        <strong>Penulis</strong>
                        <span>{{ $dataBuku['penulis'] }}</span>
                    </p>

                    <p>
                        <strong>Tahun Terbit</strong>
                        <span>{{ $dataBuku['tahun'] }}</span>
                    </p>

                    <p>
                        <strong>Kategori</strong>
                        <span>{{ $dataBuku['kategori'] }}</span>
                    </p>

                </div>

                <a href="{{ route('buku.index') }}" class="btn">
                    ← Kembali ke Daftar Buku
                </a>

            </div>

        </div>

    @else

        <div class="not-found">

            <div class="not-found-icon">
                📚
            </div>

            <h2>Buku Tidak Ditemukan</h2>

            <p>
                Maaf, data buku dengan ID tersebut tidak tersedia.
            </p>

            <a href="{{ route('buku.index') }}" class="btn">
                Kembali ke Daftar Buku
            </a>

        </div>

    @endif

@endsection