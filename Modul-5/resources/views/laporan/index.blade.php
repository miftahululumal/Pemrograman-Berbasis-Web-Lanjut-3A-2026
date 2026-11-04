
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Laporan Perpustakaan</h4>

    {{-- Ringkasan Data --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Buku</h6>
                    <h3>{{ $totalBuku }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Pengguna</h6>
                    <h3>{{ $totalPengguna }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Peminjaman</h6>
                    <h3>{{ $totalPeminjaman }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Pengembalian</h6>
                    <h3>{{ $totalPengembalian }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Laporan Peminjaman --}}
    <div class="card shadow-sm">
        <div class="card-header">
            <strong>Riwayat Peminjaman Buku</strong>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Anggota</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Denda</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($laporanPeminjaman as $peminjaman)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $peminjaman->anggota->nama ?? '-' }}
                                </td>
                                <td>
                                    {{ $peminjaman->buku->judul ?? '-' }}
                                </td>
                                <td>
                                    {{ $peminjaman->tanggal_pinjam?->format('d-m-Y') ?? '-' }}
                                </td>
                                <td>
                                    {{ $peminjaman->tanggal_kembali?->format('d-m-Y') ?? '-' }}
                                </td>
                                <td>
                                    {{ ucfirst($peminjaman->status ?? '-') }}
                                </td>
                                <td>
                                    Rp {{ number_format((float) $peminjaman->denda, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    Belum ada data peminjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

