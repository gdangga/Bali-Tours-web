@extends('layouts.admin')

@section('title', 'Manajemen Booking')

@section('content')
    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">ID</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Pelanggan</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Paket Tour</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Tgl Tour</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Total Harga</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Status</th>
                    <th class="text-center py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($bookings as $booking)
                    <tr class="border-b hover:bg-orange-50">
                        <td class="text-left py-3 px-4 font-semibold">#{{ $booking->id }}</td>
                        <td class="text-left py-3 px-4">{{ $booking->user->name }}</td>
                        <td class="text-left py-3 px-4">{{ $booking->package->name }}</td>
                        <td class="text-left py-3 px-4">{{ \Carbon\Carbon::parse($booking->tour_date)->format('d M Y') }}</td>
                        <td class="text-left py-3 px-4">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        <td class="text-left py-3 px-4">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-yellow-200 text-yellow-800',
                                    'confirmed' => 'bg-blue-200 text-blue-800',
                                    'completed' => 'bg-green-200 text-green-800',
                                    'cancelled' => 'bg-red-200 text-red-800',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$booking->status] ?? 'bg-gray-200 text-gray-800' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="text-center py-3 px-4">
                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="bg-indigo-500 text-white px-3 py-1 rounded text-sm hover:bg-indigo-600">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500">Belum ada data booking.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">
            {{ $bookings->links() }}
        </div>
    </div>
@endsection