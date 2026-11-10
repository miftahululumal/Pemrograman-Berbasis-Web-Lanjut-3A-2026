<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Policies\PeminjamanPolicy;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Peminjaman::class, PeminjamanPolicy::class);

        // Gate Otorisasi Kelola Buku (Soal 3)
        Gate::define('kelola-buku', function (User $user) {
            // Cek via Spatie Permission ATAU via kolom 'role' di tabel users
            return $user->hasAnyRole(['admin', 'petugas']) 
                || in_array($user->role, ['admin', 'petugas']);
        });
    }
}
