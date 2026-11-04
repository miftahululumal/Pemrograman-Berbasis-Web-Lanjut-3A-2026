
@extends('layouts.app')

@section('title', 'Kelola Pengguna')
@section('page-title', 'Kelola Pengguna')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Kelola Pengguna</h4>
            <p class="text-muted mb-0">
                Daftar akun pengguna perpustakaan.
            </p>
        </div>

        <a href="{{ route('pengguna.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Pengguna
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pengguna</th>
                            <th>Email</th>
                            <th>Peran</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $user->name }}</td>

                                <td>{{ $user->email }}</td>

                                <td>
                                    @forelse($user->roles as $role)
                                        <span class="badge bg-primary">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @empty
                                        <span class="badge bg-secondary">
                                            Belum ada peran
                                        </span>
                                    @endforelse
                                </td>

                                <td>
                                    {{ $user->created_at?->format('d-m-Y') ?? '-' }}
                                </td>

                                <td>
                                    <div class="d-flex gap-2">

                                        <a href="{{ route('pengguna.edit', $user->id) }}"
                                           class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('pengguna.destroy', $user->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Belum ada data pengguna.
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
