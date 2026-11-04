
@extends('layouts.app')

@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-bold">Tambah Pengguna</h4>
        <p class="text-muted">Tambahkan akun pengguna baru ke perpustakaan.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('pengguna.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Pengguna</label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           placeholder="Masukkan nama pengguna">

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}"
                           placeholder="Masukkan email">

                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Minimal 8 karakter">

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password"
                           name="password_confirmation"
                           class="form-control"
                           placeholder="Ulangi password">
                </div>

                <div class="alert alert-info">
                    Pengguna baru akan otomatis mendapatkan peran
                    <strong>Siswa</strong>.
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        Simpan Pengguna
                    </button>

                    <a href="{{ route('pengguna.index') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection
