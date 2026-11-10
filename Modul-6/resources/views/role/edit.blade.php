
@extends('layouts.app')

@section('title', 'Edit Role')
@section('page-title', 'Edit Role dan Permission')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-bold">Edit Role</h4>
        <p class="text-muted">
            Atur nama role dan hak akses pengguna.
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('role.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label fw-bold">Nama Role</label>

                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $role->name) }}">

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <hr>

                <h5 class="fw-bold mb-3">Pengaturan Permission</h5>

                <div class="row">

                    @foreach([
                        'Akses dashboard admin',
                        'Akses dashboard petugas',
                        'Lihat daftar buku',
                        'Kelola data buku',
                        'Kelola data pengguna',
                        'Kelola role pengguna',
                        'Kelola peminjaman',
                        'Kelola pengembalian',
                        'Mengajukan peminjaman buku',
                        'Memproses persetujuan peminjaman',
                        'Mencatat pengembalian buku',
                        'Melihat status peminjaman sendiri',
                        'Melihat riwayat peminjaman sendiri',
                        'Lihat laporan perpustakaan',
                        'Lihat profil sendiri',
                        'Ubah profil sendiri'
                    ] as $permission)

                        <div class="col-md-6 mb-3">
                            <div class="form-check border rounded p-3 ps-5">

                                <input class="form-check-input"
                                       type="checkbox"
                                       name="permissions[]"
                                       value="{{ $permission }}"
                                       id="permission_{{ $loop->index }}"
                                       {{ in_array($permission, old('permissions', $role->permissions->pluck('name')->toArray())) ? 'checked' : '' }}>

                                <label class="form-check-label"
                                       for="permission_{{ $loop->index }}">
                                    {{ $permission }}
                                </label>

                            </div>
                        </div>

                    @endforeach

                </div>

                <div class="d-flex gap-2 mt-3">

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i>
                        Simpan Perubahan
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
