
@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Riwayat Peminjaman</h4>
            <p class="text-muted mb-0">
                Daftar buku yang sudah dikembalikan oleh siswa.
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Batas Pengembalian</th>
                            <th>Tanggal Dikembalikan</th>
                            <th>Denda</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($peminjamans as $peminjaman)
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
                                    {{ $peminjaman->tanggal_dikembalikan?->format('d-m-Y') ?? '-' }}
                                </td>
                                <td>
                                    Rp{{ number_format((float) $peminjaman->denda, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        Sudah Dikembalikan
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    Belum ada riwayat peminjaman yang dikembalikan.
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
