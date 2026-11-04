<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-xl font-bold text-gray-800">
                    Selamat Datang, {{ Auth::user()->name }}!
                </h3>

                <p class="text-gray-600 mt-2">
                    Anda login sebagai Admin Perpustakaan.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @can('Lihat daftar buku')
                <a href="{{ route('buku.index') }}"
                   class="bg-white p-6 shadow-sm rounded-lg hover:bg-gray-50">
                    <h4 class="text-lg font-bold text-gray-800">
                        Data Buku
                    </h4>
                    <p class="text-gray-600 mt-2">
                        Lihat daftar buku perpustakaan.
                    </p>
                </a>
                @endcan

                @can('Kelola data pengguna')
                <div class="bg-white p-6 shadow-sm rounded-lg">
                    <h4 class="text-lg font-bold text-gray-800">
                        Kelola Pengguna
                    </h4>
                    <p class="text-gray-600 mt-2">
                        Fitur pengelolaan pengguna akan dibuat selanjutnya.
                    </p>
                </div>
                @endcan

                @can('Kelola role pengguna')
                <div class="bg-white p-6 shadow-sm rounded-lg">
                    <h4 class="text-lg font-bold text-gray-800">
                        Kelola Role
                    </h4>
                    <p class="text-gray-600 mt-2">
                        Fitur pengelolaan role akan dibuat selanjutnya.
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