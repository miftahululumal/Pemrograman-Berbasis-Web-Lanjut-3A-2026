<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache permission Spatie
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();

        // 1. Membuat 16 Permission sesuai Modul V
        $permissions = [
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
            'Ubah profil sendiri',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // 2. Membuat Role Admin, Petugas, dan Siswa
        $roleAdmin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $rolePetugas = Role::firstOrCreate([
            'name' => 'petugas',
            'guard_name' => 'web',
        ]);

        $roleSiswa = Role::firstOrCreate([
            'name' => 'siswa',
            'guard_name' => 'web',
        ]);

        // 3. Permission untuk Admin
        $roleAdmin->syncPermissions([
            'Akses dashboard admin',
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
            'Ubah profil sendiri',
        ]);

        // 4. Permission untuk Petugas
        $rolePetugas->syncPermissions([
            'Akses dashboard petugas',
            'Lihat daftar buku',
            'Kelola data buku',
            'Kelola peminjaman',
            'Kelola pengembalian',
            'Mengajukan peminjaman buku',
            'Memproses persetujuan peminjaman',
            'Mencatat pengembalian buku',
            'Melihat status peminjaman sendiri',
            'Melihat riwayat peminjaman sendiri',
            'Lihat laporan perpustakaan',
            'Lihat profil sendiri',
            'Ubah profil sendiri',
        ]);

        // 5. Permission untuk Siswa
        $roleSiswa->syncPermissions([
            'Lihat daftar buku',
            'Mengajukan peminjaman buku',
            'Melihat status peminjaman sendiri',
            'Melihat riwayat peminjaman sendiri',
            'Lihat profil sendiri',
            'Ubah profil sendiri',
        ]);

        // 6. Membuat akun pengujian jika belum tersedia
        $admin = User::firstOrCreate(
            ['email' => 'admin@perpustakaan.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'),
            ]
        );

        $admin->syncRoles([$roleAdmin]);

        $petugas = User::firstOrCreate(
            ['email' => 'petugas@perpustakaan.com'],
            [
                'name' => 'Petugas Perpustakaan',
                'password' => Hash::make('password123'),
            ]
        );

        $petugas->syncRoles([$rolePetugas]);

        $siswa = User::firstOrCreate(
            ['email' => 'siswa@perpustakaan.com'],
            [
                'name' => 'Siswa Utama',
                'password' => Hash::make('password123'),
            ]
        );

        $siswa->syncRoles([$roleSiswa]);

        // 7. Reset cache setelah semua permission diberikan
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();
    }
}