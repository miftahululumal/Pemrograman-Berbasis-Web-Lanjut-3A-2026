
@extends('layouts.app')

@section('title', 'Kelola Role')
@section('page-title', 'Kelola Role')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Kelola Role</h4>
            <p class="text-muted mb-0">
                Daftar peran pengguna perpustakaan.
            </p>
        </div>

        <a href="{{ route('role.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Role
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
                            <th>Nama Role</th>
                            <th>Jumlah Pengguna</th>
                            <th>Permissions</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <span class="badge bg-primary">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                </td>

                                <td>
                                    {{ $role->users()->count() }} pengguna
                                </td>

                                <td>
                                    @forelse($role->permissions as $permission)
                                        <span class="badge bg-secondary mb-1">
                                            {{ $permission->name }}
                                        </span>
                                    @empty
                                        <span class="text-muted">
                                            Belum ada permission
                                        </span>
                                    @endforelse
                                </td>

                                <td>
                                    <div class="d-flex gap-2">

                                        <a href="{{ route('role.edit', $role->id) }}"
                                           class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        @if(!in_array($role->name, ['admin', 'petugas', 'siswa']))
                                            <form action="{{ route('role.destroy', $role->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus role ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-sm btn-secondary"
                                                    disabled
                                                    title="Role bawaan sistem tidak dapat dihapus">
                                                <i class="bi bi-lock"></i>
                                            </button>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Belum ada data role.
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
