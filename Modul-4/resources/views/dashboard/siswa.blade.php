<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Siswa
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-xl font-bold text-gray-800">
                    Selamat Datang, {{ Auth::user()->name }}!
                </h3>

                <p class="text-gray-600 mt-2">
                    Anda login sebagai Siswa Perpustakaan.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @can('Lihat daftar buku')
                <a href="{{ route('buku.index') }}"
                   class="bg-white p-6 shadow-sm rounded-lg hover:bg-gray-50">
                    <h4 class="text-lg font-bold text-gray-800">
                        Daftar Buku
                    </h4>
                    <p class="text-gray-600 mt-2">
                        Lihat koleksi buku yang tersedia di perpustakaan.
                    </p>
                </a>
                @endcan

                @can('Mengajukan peminjaman buku')
                <div class="bg-white p-6 shadow-sm rounded-lg">
                    <h4 class="text-lg font-bold text-gray-800">
                        Ajukan Peminjaman
                    </h4>
                    <p class="text-gray-600 mt-2">
                        Fitur pengajuan peminjaman akan dibuat selanjutnya.
                    </p>
                </div>
                @endcan

                @can('Melihat status peminjaman sendiri')
                <div class="bg-white p-6 shadow-sm rounded-lg">
                    <h4 class="text-lg font-bold text-gray-800">
                        Status Peminjaman
                    </h4>
                    <p class="text-gray-600 mt-2">
                        Fitur melihat status peminjaman akan dibuat selanjutnya.
                    </p>
                </div>
                @endcan

                @can('Melihat riwayat peminjaman sendiri')
                <div class="bg-white p-6 shadow-sm rounded-lg">
                    <h4 class="text-lg font-bold text-gray-800">
                        Riwayat Peminjaman
                    </h4>
                    <p class="text-gray-600 mt-2">
                        Fitur riwayat peminjaman akan dibuat selanjutnya.
                    </p>
                </div>
                @endcan

                <a href="{{ route('profile.edit') }}"
                   class="bg-white p-6 shadow-sm rounded-lg hover:bg-gray-50">
                    <h4 class="text-lg font-bold text-gray-800">
                        Profil Saya
                    </h4>
                    <p class="text-gray-600 mt-2">
                        Lihat dan ubah profil akun Anda.
                    </p>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>