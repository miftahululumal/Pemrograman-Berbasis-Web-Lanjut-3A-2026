<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // Menampilkan daftar peminjaman
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('siswa')) {
            $anggota = Anggota::firstOrCreate(
                ['email' => $user->email],
                [
                    'nama' => $user->name,
                    'no_telepon' => '-',
                ]
            );

            // Siswa hanya melihat peminjamannya sendiri
            $peminjamans = Peminjaman::with(['anggota', 'buku', 'pemroses'])
                ->where('anggota_id', $anggota->id)
                ->latest()
                ->get();
        } else {
            // Admin dan petugas melihat semua peminjaman
            $peminjamans = Peminjaman::with(['anggota', 'buku', 'pemroses'])
                ->latest()
                ->get();
        }

        return view('peminjaman.index', compact('peminjamans'));
    }

    // Menampilkan riwayat peminjaman yang sudah dikembalikan
    public function riwayat()
    {
        $peminjamans = Peminjaman::with(['anggota', 'buku', 'pemroses'])
            ->where('status_pengembalian', 'sudah dikembalikan')
            ->latest('tanggal_dikembalikan')
            ->get();

        return view('peminjaman.riwayat', compact('peminjamans'));
    }

    // Form pengajuan peminjaman
    public function create()
    {
        $bukus = Buku::orderBy('judul')->get();

        return view('peminjaman.create', compact('bukus'));
    }

    // Menyimpan pengajuan peminjaman
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $user = Auth::user();

        $anggota = Anggota::firstOrCreate(
            ['email' => $user->email],
            [
                'nama' => $user->name,
                'no_telepon' => '-',
            ]
        );

        Peminjaman::create([
            'anggota_id' => $anggota->id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'menunggu',
        ]);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }

    // Menyetujui pengajuan peminjaman
    public function approve($id)
    {
        $user = Auth::user();

        abort_unless(
            $user->hasAnyRole(['admin', 'petugas']),
            403
        );

        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return redirect()->route('peminjaman.index')
                ->with('error', 'Pengajuan ini sudah diproses.');
        }

        $peminjaman->update([
            'status' => 'disetujui',
            'diproses_oleh' => $user->id,
            'alasan_penolakan' => null,
        ]);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil disetujui.');
    }

    // Menolak pengajuan peminjaman
    public function reject(Request $request, $id)
    {
        $user = Auth::user();

        abort_unless(
            $user->hasAnyRole(['admin', 'petugas']),
            403
        );

        $request->validate([
            'alasan_penolakan' => 'required|string|max:1000',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return redirect()->route('peminjaman.index')
                ->with('error', 'Pengajuan ini sudah diproses.');
        }

        $peminjaman->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan,
            'diproses_oleh' => $user->id,
        ]);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil ditolak.');
    }
}
