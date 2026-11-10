<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Utama') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Info Akun yang Sedang Login -->
                <h3 class="text-xl font-bold text-gray-800 mb-2">
                    Selamat Datang, {{ auth()->user()->name }}!
                </h3>
                <p class="text-sm text-gray-600 mb-6">
                    Role Anda saat ini: 
                    <span class="font-bold text-emerald-600 uppercase">
                        {{ auth()->user()->getRoleNames()->first() ?? 'Siswa' }}
                    </span>
                </p>

                <hr class="mb-6">

                <!-- Tombol Navigasi Sesuai Role -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <!-- Menu Buku (Semua Role Bisa Lihat) -->
                    <a href="{{ route('buku.index') }}" class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg hover:bg-emerald-100 transition">
                        <h4 class="font-bold text-emerald-800">📚 Masuk ke Halaman Buku</h4>
                        <p class="text-sm text-emerald-600">
                            @can('Kelola data buku')
                                Anda bisa Tambah, Edit, dan Hapus Buku.
                            @else
                                Anda hanya bisa melihat daftar buku.
                            @endcan
                        </p>
                    </a>

                    <!-- Fitur Khusus Admin & Petugas -->
                    @can('Kelola peminjaman')
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h4 class="font-bold text-blue-800">🔄 Kelola Peminjaman</h4>
                        <p class="text-sm text-blue-600">Proses peminjaman dan pengembalian buku.</p>
                    </div>
                    @endcan

                </div>

            </div>
        </div>
    </div>
</x-app-layout>