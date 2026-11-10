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
            $anggota = Anggota::where('email', $user->email)->firstOrFail();

            $peminjamans = Peminjaman::with(['anggota', 'buku'])
                ->where('anggota_id', $anggota->id)
                ->latest()
                ->get();
        } else {
            $peminjamans = Peminjaman::with(['anggota', 'buku'])
                ->latest()
                ->get();
        }   

        return view('peminjaman.index', compact('peminjamans'));
    }

    // Menampilkan formulir pengajuan
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

        $anggota = Anggota::where('email', Auth::user()->email)
            ->firstOrFail();

        Peminjaman::create([
            'anggota_id' => $anggota->id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
        ]);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }

    // SOAL 1 (A4): Celah IDOR (Menampilkan detail peminjaman tanpa otorisasi pemilik)
    public function show($id)
    {
        $peminjaman = \App\Models\Peminjaman::with(['user', 'buku'])->find($id);

        if (!$peminjaman) {
            return response()->json(['message' => 'Data peminjaman tidak ditemukan'], 404);
        }

        return response()->json($peminjaman);
    }
}
