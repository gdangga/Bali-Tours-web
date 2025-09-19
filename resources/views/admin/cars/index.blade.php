@extends('layouts.admin')

@section('title', 'Manajemen Mobil')

@section('content')
    <div class="mb-6 text-right">
        <a href="{{ route('admin.cars.create') }}" class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-300 ease-in-out transform hover:scale-105">
            + Tambah Mobil
        </a>
    </div>

    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Gambar</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Nama Mobil</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Kapasitas</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Harga/Hari</th>
                    <th class="text-center py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($cars as $car)
                    <tr class="border-b hover:bg-orange-50">
                        <td class="py-3 px-4"><img src="{{ Storage::url($car->image) }}" alt="{{ $car->name }}" class="h-16 w-24 object-cover rounded shadow"></td>
                        <td class="text-left py-3 px-4 font-semibold">{{ $car->name }}</td>
                        <td class="text-left py-3 px-4">{{ $car->capacity }} orang</td>
                        <td class="text-left py-3 px-4">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</td>
                        <td class="text-center py-3 px-4">
                            <a href="{{ route('admin.cars.edit', $car->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600 transition duration-300">Edit</a>
                            
                            {{-- Tombol Hapus dengan SweetAlert --}}
                            <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST" class="inline-block delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition duration-300">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">Tidak ada data mobil.</td>
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
                    text: "Data mobil ini akan dihapus secara permanen!",
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
                });
            });
        });
    </script>
@endsection