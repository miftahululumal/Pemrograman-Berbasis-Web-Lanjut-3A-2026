<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    // Denda keterlambatan per hari
    private $dendaPerHari = 1000;

    // Halaman pengembalian untuk admin dan petugas
    public function index()
    {
        $belumDikembalikan = Peminjaman::with(['anggota', 'buku'])
            ->where('status', 'disetujui')
            ->where('status_pengembalian', 'belum dikembalikan')
            ->orderBy('tanggal_kembali')
            ->get();

        $sudahDikembalikan = Peminjaman::with(['anggota', 'buku', 'pemroses'])
            ->where('status_pengembalian', 'sudah dikembalikan')
            ->orderByDesc('tanggal_dikembalikan')
            ->get();

        return view('pengembalian.index', compact(
            'belumDikembalikan',
            'sudahDikembalikan'
        ));
    }

    // Pengembalian dicatat oleh admin atau petugas
    public function catatPengembalian($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'disetujui') {
            return back()->with('error', 'Peminjaman belum disetujui.');
        }

        if ($peminjaman->status_pengembalian === 'sudah dikembalikan') {
            return back()->with('error', 'Buku ini sudah dikembalikan.');
        }

        $this->prosesPengembalian($peminjaman);

        return redirect()
            ->route('pengembalian.index')
            ->with('success', 'Pengembalian buku berhasil dicatat.');
    }

    // Pengembalian dilakukan oleh siswa melalui akun sendiri
    public function kembalikanOlehSiswa($id)
    {
        $user = Auth::user();

        if (!$user->hasRole('siswa')) {
            abort(403, 'Fitur ini khusus untuk siswa.');
        }

        $anggota = Anggota::where('email', $user->email)->first();

        if (!$anggota) {
            return back()->with('error', 'Data anggota tidak ditemukan.');
        }

        $peminjaman = Peminjaman::where('id', $id)
            ->where('anggota_id', $anggota->id)
            ->firstOrFail();

        if ($peminjaman->status !== 'disetujui') {
            return back()->with('error', 'Peminjaman belum disetujui.');
        }

        if ($peminjaman->status_pengembalian === 'sudah dikembalikan') {
            return back()->with('error', 'Buku ini sudah dikembalikan.');
        }

        $this->prosesPengembalian($peminjaman);

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Pengembalian buku berhasil dilakukan.');
    }

    // Proses bersama untuk mencatat pengembalian dan menghitung denda
    private function prosesPengembalian(Peminjaman $peminjaman)
    {
        $tanggalHariIni = Carbon::today();

        $tanggalBatas = Carbon::parse($peminjaman->tanggal_kembali);

        $hariTerlambat = 0;

        if ($tanggalHariIni->gt($tanggalBatas)) {
            $hariTerlambat = (int) $tanggalBatas->diffInDays(
                $tanggalHariIni
            );
        }

        $denda = $hariTerlambat * $this->dendaPerHari;

        $peminjaman->update([
            'tanggal_dikembalikan' => $tanggalHariIni,
            'denda' => $denda,
            'status_pengembalian' => 'sudah dikembalikan',
        ]);
    }
}