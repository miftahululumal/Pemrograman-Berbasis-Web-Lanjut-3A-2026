
@extends('layouts.app')

@section('title', 'Tambah Role')
@section('page-title', 'Tambah Role')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-bold">Tambah Role</h4>
        <p class="text-muted">
            Tambahkan peran baru untuk pengguna perpustakaan.
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('role.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Role</label>

                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           placeholder="Contoh: kepala_perpustakaan">

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <small class="text-muted">
                        Gunakan nama role yang singkat dan mudah dipahami.
                    </small>
                </div>

                <div class="alert alert-info">
                    Role baru belum memiliki permission.
                    Permission dapat diatur melalui fitur edit role.
                </div>

                <div class="d-flex gap-2">

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i>
                        Simpan Role
                    </button>

                    <a href="{{ route('role.index') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection
