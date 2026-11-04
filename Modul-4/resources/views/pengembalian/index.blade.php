
@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Pengembalian Buku</h3>
            <p class="text-muted mb-0">
                Kelola pengembalian dan lihat riwayat pengembalian buku.
            </p>
        </div>
    </div>

    {{-- PESAN BERHASIL --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- PESAN ERROR --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    {{-- BUKU YANG BELUM DIKEMBALIKAN --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Menunggu Pengembalian</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Anggota</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Batas Pengembalian</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($belumDikembalikan as $peminjaman)
                            @php
                                $terlambat = now()->startOfDay()->gt(
                                    \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->startOfDay()
                                );
                            @endphp

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $peminjaman->anggota->nama ?? '-' }}</td>
                                <td>{{ $peminjaman->buku->judul ?? '-' }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y') }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y') }}
                                </td>
                                <td>
                                    @if($terlambat)
                                        <span class="badge bg-danger">Terlambat</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Belum dikembalikan</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('pengembalian.catat', $peminjaman->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Catat buku ini sudah dikembalikan?')">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            Catat Pengembalian
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Tidak ada buku yang menunggu pengembalian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    {{-- RIWAYAT PENGEMBALIAN --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Riwayat Pengembalian</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Anggota</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Batas Pengembalian</th>
                            <th>Tanggal Dikembalikan</th>
                            <th>Denda</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($sudahDikembalikan as $peminjaman)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $peminjaman->anggota->nama ?? '-' }}</td>
                                <td>{{ $peminjaman->buku->judul ?? '-' }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y') }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y') }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_dikembalikan)->format('d-m-Y') }}
                                </td>
                                <td>
                                    Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        Sudah Dikembalikan
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    Belum ada riwayat pengembalian buku.
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
