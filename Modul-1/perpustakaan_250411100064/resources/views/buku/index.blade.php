@extends('layouts.app')

@section('title', 'Daftar Buku - Perpustakaan')

@section('content')

    <div class="page-header">
        <div>
            <span class="badge">KOLEKSI BUKU</span>

            <h2>Daftar Buku</h2>

            <p>
                Temukan berbagai koleksi buku yang tersedia
                di Perpustakaan Digital.
            </p>
        </div>
    </div>

    <div class="book-grid">

        @foreach ($buku as $item)

            <x-book-card
    :judul="$item['judul']"
    :penulis="$item['penulis']"
    :tahun="$item['tahun']"
    :url="route('buku.show', $item['id'])"
    :cover="$item['cover']"
>
    <span class="book-category">
        {{ $item['kategori'] }}
    </span>
</x-book-card>

        @endforeach

    </div>

@endsection