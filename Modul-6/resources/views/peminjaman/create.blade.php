@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Ajukan Peminjaman Buku</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Pilih Buku</label>
                    <select name="buku_id" class="form-select" required>
                        <option value="">-- Pilih Buku --</option>

                        @foreach ($bukus as $buku)
                            <option value="{{ $buku->id }}"
                                {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                                {{ $buku->judul }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam"
                        class="form-control"
                        value="{{ old('tanggal_pinjam') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali"
                        class="form-control"
                        value="{{ old('tanggal_kembali') }}" required>
                </div>

                <button type="submit" class="btn btn-success">
                    Kirim Pengajuan
                </button>

                <a href="{{ route('peminjaman.index') }}"
                    class="btn btn-secondary">
                    Kembali
                </a>
            </form>

        </div>
    </div>
</div>
@endsection