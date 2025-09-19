@extends('layouts.admin')

@section('title', 'Manajemen Paket Tour')

@section('content')
    <div class="mb-6 text-right">
        <a href="{{ route('admin.packages.create') }}" class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-300 ease-in-out transform hover:scale-105">
            + Tambah Paket
        </a>
    </div>

    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="w-1/12 text-left py-3 px-4 uppercase font-semibold text-sm">#</th>
                    <th class="w-2/12 text-left py-3 px-4 uppercase font-semibold text-sm">Thumbnail</th>
                    <th class="w-4/12 text-left py-3 px-4 uppercase font-semibold text-sm">Nama Paket</th>
                    <th class="w-2/12 text-left py-3 px-4 uppercase font-semibold text-sm">Harga</th>
                    <th class="w-3/12 text-center py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($packages as $package)
                    <tr class="border-b hover:bg-orange-50">
                        <td class="text-left py-3 px-4">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4">
                            <img src="{{ Storage::url($package->thumbnail) }}" alt="{{ $package->name }}" class="h-16 w-16 object-cover rounded-md shadow">
                        </td>
                        <td class="text-left py-3 px-4 font-semibold">{{ $package->name }}</td>
                        <td class="text-left py-3 px-4">Rp {{ number_format($package->price, 0, ',', '.') }}</td>
                        <td class="text-center py-3 px-4">
                            <a href="{{ route('admin.packages.edit', $package->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600 transition duration-300">Edit</a>
                            
                            {{-- Tombol Hapus dengan SweetAlert --}}
                            <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" class="inline-block delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition duration-300">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">Tidak ada data paket yang ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Script untuk konfirmasi hapus dengan SweetAlert --}}
    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault(); // Mencegah form dikirim secara langsung
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang akan dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#F97316', // Oranye
                    cancelButtonColor: '#6B7280', // Abu-abu
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Kirim form jika pengguna mengonfirmasi
                    }
                })
            });
        });
    </script>
@endsection