<?php

namespace App\Models; // Sesuaikan namespace jika ada di App\Policies

namespace App\Policies;

use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PeminjamanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the peminjaman.
     */
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        // 1. Ambil nama role user 
        $userData = strtolower(json_encode($user->toArray()));

        // 2. Admin & Petugas boleh melihat SEMUA peminjaman
        if (str_contains($userData, 'admin') || str_contains($userData, 'petugas')) {
            return true;
        }

        // 3. Siswa HANYA boleh melihat peminjaman miliknya sendiri (mencegah IDOR)
        return (int) $user->id === (int) $peminjaman->user_id;
    }
}