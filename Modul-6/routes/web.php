
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\LaporanController;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\Buku;

// ==========================================
// HALAMAN BERANDA
// ==========================================
Route::get('/', function () {
    return view('home');
})->name('home');


// ==========================================
// ROUTE KHUSUS PENGGUNA YANG SUDAH LOGIN
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {

    // Mengarahkan pengguna sesuai role
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('dashboard.admin');
        }

        if ($user->hasRole('petugas')) {
            return redirect()->route('dashboard.petugas');
        }

        if ($user->hasRole('siswa')) {
            return redirect()->route('dashboard.siswa');
        }

        abort(403, 'Role pengguna belum ditentukan.');
    })->name('dashboard');


    // ======================================
    // DASHBOARD ADMIN
    // ======================================
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard/admin', function () {
            return view('dashboard.admin');
        })->name('dashboard.admin');
    });


    // ======================================
    // DASHBOARD PETUGAS
    // ======================================
    Route::middleware('role:petugas')->group(function () {
        Route::get('/dashboard/petugas', function () {
            return view('dashboard.petugas');
        })->name('dashboard.petugas');
    });


    // ======================================
    // DASHBOARD SISWA
    // ======================================
    Route::middleware('role:siswa')->group(function () {

        Route::get('/dashboard/siswa', function () {

            $user = auth()->user();

            // Cari data anggota berdasarkan email akun login
            $anggota = Anggota::where('email', $user->email)->first();

            // Ambil peminjaman milik siswa
            $peminjamans = collect();

            if ($anggota) {
                $peminjamans = Peminjaman::with('buku')
                    ->where('anggota_id', $anggota->id)
                    ->latest()
                    ->get();
            }

            // Statistik peminjaman
            $totalPeminjaman = $peminjamans->count();

            $menunggu = $peminjamans
                ->where('status', 'menunggu')
                ->count();

            $disetujui = $peminjamans
                ->where('status', 'disetujui')
                ->count();

            $ditolak = $peminjamans
                ->where('status', 'ditolak')
                ->count();

            // Buku terbaru
            $bukuTerbaru = Buku::latest()
                ->take(5)
                ->get();

            return view('dashboard.siswa', compact(
                'anggota',
                'peminjamans',
                'totalPeminjaman',
                'menunggu',
                'disetujui',
                'ditolak',
                'bukuTerbaru'
            ));

        })->name('dashboard.siswa');
    });
    
    // ======================================
    // CRUD BUKU
    // ======================================
        Route::middleware('can:kelola-buku')->group(function () {
        Route::get('/buku/create', [BukuController::class, 'create'])
            ->name('buku.create');

        Route::post('/buku', [BukuController::class, 'store'])
            ->name('buku.store');

        Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])
            ->name('buku.edit');

        Route::put('/buku/{buku}', [BukuController::class, 'update'])
            ->name('buku.update');

        Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])
            ->name('buku.destroy');
    });


    // ======================================
    // DAFTAR DAN DETAIL BUKU
    // ======================================
    Route::middleware('permission:Lihat daftar buku')->group(function () {

        Route::get('/buku', [BukuController::class, 'index'])
            ->name('buku.index');

        Route::get('/buku/{buku}', [BukuController::class, 'show'])
            ->name('buku.show');
    });


    // ======================================
    // PENGOLAHAN PENGGUNA
    // KHUSUS ADMIN
    // ======================================
    Route::middleware([
        'role:admin',
        'permission:Kelola data pengguna'
    ])->group(function () {

        Route::get('/pengguna', [UserController::class, 'index'])
            ->name('pengguna.index');

        Route::get('/pengguna/tambah', [UserController::class, 'create'])
            ->name('pengguna.create');

        Route::post('/pengguna', [UserController::class, 'store'])
            ->name('pengguna.store');

        Route::get('/pengguna/{id}/edit', [UserController::class, 'edit'])
            ->name('pengguna.edit');

        Route::put('/pengguna/{id}', [UserController::class, 'update'])
            ->name('pengguna.update');

        Route::delete('/pengguna/{id}', [UserController::class, 'destroy'])
            ->name('pengguna.destroy');
    });


    // ======================================
    // PENGOLAHAN ROLE
    // KHUSUS ADMIN
    // ======================================
    Route::middleware([
        'role:admin',
        'permission:Kelola role pengguna'
    ])->group(function () {

        Route::get('/role', [RoleController::class, 'index'])
            ->name('role.index');

        Route::get('/role/tambah', [RoleController::class, 'create'])
            ->name('role.create');

        Route::post('/role', [RoleController::class, 'store'])
            ->name('role.store');

        Route::get('/role/{id}/edit', [RoleController::class, 'edit'])
            ->name('role.edit');

        Route::put('/role/{id}', [RoleController::class, 'update'])
            ->name('role.update');

        // Soal 2 3A ETE)
        Route::delete('/role/{id}', [RoleController::class, 'destroy'])
            ->name('role.destroy');
    });


    // ======================================
    // PEMINJAMAN BUKU
    // ======================================
    Route::middleware(
        'permission:Melihat status peminjaman sendiri|Kelola peminjaman'
    )->group(function () {

        Route::get('/peminjaman', [PeminjamanController::class, 'index'])
            ->name('peminjaman.index');
    });


    // Mengajukan peminjaman buku
    Route::middleware('permission:Mengajukan peminjaman buku')->group(function () {

        Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])
            ->name('peminjaman.create');

        Route::post('/peminjaman', [PeminjamanController::class, 'store'])
            ->name('peminjaman.store');
    });


    // Menyetujui pengajuan peminjaman
    Route::post('/peminjaman/{id}/setujui', [PeminjamanController::class, 'approve'])
        ->middleware('permission:Memproses persetujuan peminjaman')
        ->name('peminjaman.approve');


    // Menolak pengajuan peminjaman
    Route::post('/peminjaman/{id}/tolak', [PeminjamanController::class, 'reject'])
        ->middleware('permission:Memproses persetujuan peminjaman')
        ->name('peminjaman.reject');


    // ======================================
    // PENGEMBALIAN BUKU
    // ======================================
    Route::get('/pengembalian', [PengembalianController::class, 'index'])
        ->middleware('permission:Kelola pengembalian')
        ->name('pengembalian.index');


    Route::get('/riwayat-peminjaman', [PeminjamanController::class, 'riwayat'])
        ->middleware('permission:Kelola pengembalian')
        ->name('peminjaman.riwayat');


    Route::post('/peminjaman/{id}/kembalikan', [PengembalianController::class, 'kembalikanOlehSiswa'])
        ->middleware('permission:Melihat status peminjaman sendiri')
        ->name('peminjaman.kembalikan');


    Route::post('/pengembalian/{id}/catat', [PengembalianController::class, 'catatPengembalian'])
        ->middleware('permission:Mencatat pengembalian buku')
        ->name('pengembalian.catat');


    // ======================================
    // LAPORAN PERPUSTAKAAN
    // ======================================
    Route::middleware('permission:Lihat laporan perpustakaan')->group(function () {

        Route::get('/laporan', [LaporanController::class, 'index'])
            ->name('laporan.index');
    });


    // ======================================
    // PROFIL PENGGUNA
    // ======================================
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

    Route::middleware('auth')->group(function () {
    // 1. Route Cari Buku (Soal 2b - Sudah ditambal dengan Parameter Binding)
    Route::get('/buku-cari', [\App\Http\Controllers\Api\BukuController::class, 'cariBuku']);

    // 2. Route Hapus Buku Resmi (Soal 2c - Menghapus route GET A3 dan menggantinya dengan DELETE + CSRF)
    Route::delete('/buku/{buku}', [\App\Http\Controllers\Api\BukuController::class, 'destroy'])->name('buku.destroy');

    // 3. Route Detail Peminjaman (Soal 1 A4 - Celah IDOR yang nanti ditambal dengan Policy di Soal 4)
    Route::get('/peminjaman/{id}', [\App\Http\Controllers\PeminjamanController::class, 'show'])->name('peminjaman.show');
});

Route::get('/test-error', function () {
    throw new \RuntimeException("Uji coba error sistem.");
});

require __DIR__.'/auth.php';
