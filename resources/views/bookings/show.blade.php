@extends('layouts.public')

@section('content')
<div class="bg-gray-200 py-12">
    <div class="container mx-auto px-4 lg:px-20">
        
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('bookings.index') }}" class="text-orange-600 hover:underline">
                &larr; Back to Booking List
            </a>
            <button onclick="window.print()" class="bg-gray-700 text-white font-bold py-2 px-4 rounded-lg hover:bg-gray-800 flex items-center">
                <i class="fas fa-print mr-2"></i> Print
            </button>
        </div>

        <div class="bg-white p-8 md:p-12 rounded-lg shadow-lg" id="invoice">
            {{-- Header Invoice --}}
            <div class="flex justify-between items-start border-b pb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">INVOICE</h1>
                    <p class="text-gray-500">#{{ $booking->id }}</p>
                </div>
                <div class="text-right">
                    <img src="{{ asset('Logo PBT Transparantw.png') }}" class="h-16" alt="Logo PBT" />
                    <p class="text-sm font-semibold">Putra Bali Tour</p>
                </div>
            </div>

            {{-- Info Klien & Tanggal --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-6">
                <div>
                    <h2 class="font-semibold text-gray-600 mb-2">Billed To:</h2>
                    <p class="font-bold">{{ $booking->user->name }}</p>
                    <p>{{ $booking->user->email }}</p>
                    <p>{{ $booking->user->phone }}</p>
                </div>
                <div class="text-left md:text-right">
                    <p><strong class="text-gray-600">Booking Date:</strong> {{ $booking->created_at->format('d F Y') }}</p>
                    <p><strong class="text-gray-600">Tour Date:</strong> {{ \Carbon\Carbon::parse($booking->tour_date)->format('d F Y') }}</p>
                    <div class="mt-2">
                        <span class="px-3 py-1 text-md font-semibold rounded-full 
                            @if($booking->status == 'pending') bg-yellow-200 text-yellow-800 @endif
                            @if($booking->status == 'confirmed') bg-green-200 text-green-800 @endif
                            @if($booking->status == 'cancelled') bg-red-200 text-red-800 @endif">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Tabel Item --}}
            <div class="mt-10 overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 font-semibold text-gray-700">Description</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 text-center">Pax</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 text-right">Price</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="py-3 px-4">
                                <p class="font-bold">{{ $booking->package->name }}</p>
                                <p class="text-sm text-gray-600">Tour package as per itinerary</p>
                            </td>
                            <td class="py-3 px-4 text-center">{{ $booking->num_people }}</td>
                            <td class="py-3 px-4 text-right">Rp {{ number_format($booking->total_price / $booking->num_people, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-right font-bold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Total --}}
            <div class="flex justify-end mt-6">
                <div class="w-full max-w-xs">
                    <div class="flex justify-between text-lg">
                        <span class="text-gray-600">Subtotal</span>
                        <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-2xl font-bold text-orange-600 mt-2 border-t pt-2">
                        <span>Total</span>
                        <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Catatan / Detail Peserta --}}
            @if($booking->pesan_confirm)
            <div class="mt-10 border-t pt-6">
                <h2 class="font-semibold text-gray-600 mb-2">Confirmation Note:</h2>
                 <div class="prose max-w-none p-4 bg-gray-50 rounded-md text-sm">
                    {!! nl2br(e($booking->pesan_confirm)) !!}
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

<style>
    @media print {
        body {
            background-color: white;
        }
        .container {
            max-width: 100%;
            margin: 0;
            padding: 0;
        }
        a[href], button {
            display: none !important;
        }
        #invoice {
            box-shadow: none;
            border: 1px solid #e5e7eb;
        }
    }
</style>
@endsection