
@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Peminjaman Buku</h2>

        @can('Mengajukan peminjaman buku')
            <a href="{{ route('peminjaman.create') }}" class="btn btn-success">
                + Ajukan Peminjaman
            </a>
        @endcan
    </div>

    {{-- Pesan berhasil --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Pesan gagal --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Pesan validasi --}}
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">

                    <thead class="table-success">
                        <tr>
                            <th>No</th>
                            <th>Nama Anggota</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status Peminjaman</th>
                            <th>Status Pengembalian</th>
                            <th>Alasan Penolakan</th>
                            <th>Diproses Oleh</th>

                            @canany(['Memproses persetujuan peminjaman', 'Melihat status peminjaman sendiri'])
                                <th>Aksi</th>
                            @endcanany
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($peminjamans as $peminjaman)

                            @php
                                $tanggalBatas = \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->startOfDay();
                                $hariIni = now()->startOfDay();

                                $hariMenujuBatas = $hariIni->diffInDays($tanggalBatas, false);

                                $hariTerlambat = $tanggalBatas->diffInDays($hariIni, false);

                                $sudahDikembalikan = $peminjaman->status_pengembalian === 'sudah dikembalikan';
                            @endphp

                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    {{ $peminjaman->anggota->nama ?? '-' }}
                                </td>

                                <td>
                                    {{ $peminjaman->buku->judul ?? '-' }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y') }}
                                </td>

                                <td>
                                    {{ $tanggalBatas->format('d-m-Y') }}
                                </td>

                                {{-- Status peminjaman --}}
                                <td>
                                    @if($peminjaman->status == 'menunggu')
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif($peminjaman->status == 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($peminjaman->status == 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-secondary">
                                            {{ $peminjaman->status ?? 'Belum ada status' }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Status pengembalian --}}
                                <td>
                                    @if($peminjaman->status == 'ditolak')
                                        -
                                    @elseif($sudahDikembalikan)
                                        <span class="badge bg-success">Sudah Dikembalikan</span>
                                    @elseif($peminjaman->status == 'disetujui')
                                        <span class="badge bg-warning text-dark">Belum Dikembalikan</span>
                                    @else
                                        -
                                    @endif
                                </td>

                                {{-- Alasan penolakan --}}
                                <td>
                                    @if($peminjaman->status == 'ditolak')
                                        {{ $peminjaman->alasan_penolakan ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </td>

                                {{-- Nama pemroses --}}
                                <td>
                                    {{ $peminjaman->pemroses->name ?? '-' }}
                                </td>

                                {{-- Aksi --}}
                                @canany(['Memproses persetujuan peminjaman', 'Melihat status peminjaman sendiri'])
                                    <td style="min-width: 220px;">

                                        {{-- Aksi Admin dan Petugas --}}
                                        @can('Memproses persetujuan peminjaman')

                                            @if($peminjaman->status == 'menunggu')

                                                <form
                                                    action="{{ route('peminjaman.approve', $peminjaman->id) }}"
                                                    method="POST"
                                                    class="mb-2"
                                                    onsubmit="return confirm('Yakin ingin menyetujui pengajuan ini?')"
                                                >
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        Setujui
                                                    </button>
                                                </form>

                                                <form
                                                    action="{{ route('peminjaman.reject', $peminjaman->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menolak pengajuan ini?')"
                                                >
                                                    @csrf

                                                    <textarea
                                                        name="alasan_penolakan"
                                                        class="form-control form-control-sm mb-2"
                                                        rows="2"
                                                        placeholder="Masukkan alasan penolakan..."
                                                        required
                                                    ></textarea>

                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        Tolak
                                                    </button>
                                                </form>

                                            @else
                                                <span class="text-muted">Sudah diproses</span>
                                            @endif

                                        @endcan

                                        {{-- Aksi khusus siswa --}}
                                        @if(auth()->user()->hasRole('siswa'))

                                            @if($peminjaman->status == 'disetujui' && !$sudahDikembalikan)

                                                {{-- Peringatan batas pengembalian --}}
                                                @if($hariMenujuBatas >= 0 && $hariMenujuBatas <= 3)
                                                    <div class="alert alert-warning p-2 small">
                                                        <strong>Perhatian!</strong><br>

                                                        @if($hariMenujuBatas == 0)
                                                            Batas pengembalian adalah hari ini.
                                                        @else
                                                            Batas pengembalian tinggal {{ $hariMenujuBatas }} hari lagi.
                                                        @endif
                                                    </div>
                                                @elseif($hariMenujuBatas < 0)
                                                    <div class="alert alert-danger p-2 small">
                                                        <strong>Terlambat {{ $hariTerlambat }} hari!</strong><br>
                                                        Estimasi denda:
                                                        Rp{{ number_format($hariTerlambat * 1000, 0, ',', '.') }}
                                                    </div>
                                                @endif

                                                <form
                                                    action="{{ route('peminjaman.kembalikan', $peminjaman->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Apakah kamu yakin ingin mengembalikan buku ini?')"
                                                >
                                                    @csrf

                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        <i class="bi bi-arrow-return-left"></i>
                                                        Kembalikan Buku
                                                    </button>
                                                </form>

                                            @elseif($sudahDikembalikan)

                                                <span class="badge bg-success">
                                                    Buku Sudah Dikembalikan
                                                </span>

                                                <div class="small mt-1">
                                                    Denda:
                                                    Rp{{ number_format($peminjaman->denda ?? 0, 0, ',', '.') }}
                                                </div>

                                            @endif

                                        @endif

                                    </td>
                                @endcanany

                            </tr>

                        @empty

                            <tr>
                                <td colspan="10" class="text-center">
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
