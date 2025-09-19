@extends('layouts.admin')

@section('title', 'Manajemen Addons')

@section('content')
    {{-- PERBAIKAN: class pada div ini sudah benar --}}
    <div class="mb-6 text-right">
        <a href="{{ route('admin.addons.create') }}" class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-300 ease-in-out transform hover:scale-105">
            + Tambah Addon
        </a>
    </div>

    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="w-2/12 text-left py-3 px-4 uppercase font-semibold text-sm">Gambar</th>
                    <th class="w-5/12 text-left py-3 px-4 uppercase font-semibold text-sm">Nama Addon</th>
                    <th class="w-2/12 text-left py-3 px-4 uppercase font-semibold text-sm">Harga</th>
                    <th class="w-3/12 text-center py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($addons as $addon)
                    <tr class="border-b hover:bg-orange-50">
                        <td class="py-3 px-4">
                            @if($addon->image)
                                <img src="{{ Storage::url($addon->image) }}" alt="{{ $addon->name }}" class="h-16 w-16 object-cover rounded shadow">
                            @else
                                <span class="text-gray-400 text-sm">No Image</span>
                            @endif
                        </td>
                        <td class="text-left py-3 px-4 font-semibold">{{ $addon->name }}</td>
                        <td class="text-left py-3 px-4">Rp {{ number_format($addon->price, 0, ',', '.') }}</td>
                        <td class="text-center py-3 px-4">
                            <a href="{{ route('admin.addons.edit', $addon->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600 transition duration-300">Edit</a>
                            
                            <form action="{{ route('admin.addons.destroy', $addon->id) }}" method="POST" class="inline-block delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition duration-300">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-500">Tidak ada data addon yang ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data addon ini akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#F97316',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection