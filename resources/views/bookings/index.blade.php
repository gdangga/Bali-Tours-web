@extends('layouts.public')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-6 lg:px-20">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">My Booking List</h1>

        @if($bookings->isEmpty())
            <div class="bg-white p-8 rounded-lg shadow-md text-center">
                <p class="text-gray-600 text-lg">No booking list yet.</p>
                <a href="{{ route('landing') }}#packages" class="mt-4 inline-block bg-orange-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-orange-600">
                    Find Your Tour Package
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($bookings as $booking)
                <div class="bg-white p-4 rounded-lg shadow-md flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                    {{-- Gambar --}}
                    <img src="{{ Storage::url($booking->package->thumbnail) }}" alt="{{ $booking->package->name }}" class="w-full sm:w-40 h-32 object-cover rounded-md">
                    
                    {{-- Detail Utama --}}
                    <div class="flex-grow">
                        <h2 class="font-bold text-lg">{{ $booking->package->name }}</h2>
                        <p class="text-sm text-gray-500">
                            <i class="fas fa-calendar-alt fa-fw mr-1"></i>
                            {{ \Carbon\Carbon::parse($booking->tour_date)->format('d F Y') }}
                        </p>
                        <p class="text-sm text-gray-500">
                            <i class="fas fa-users fa-fw mr-1"></i>
                            {{ $booking->num_people }} Pax
                        </p>
                    </div>

                    {{-- Status dan Aksi --}}
                    <div class="w-full sm:w-auto text-left sm:text-right">
                        {{-- Status Badge --}}
                        <div class="mb-2">
                             <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($booking->status == 'pending') bg-yellow-200 text-yellow-800 @endif
                                @if($booking->status == 'confirmed') bg-green-200 text-green-800 @endif
                                @if($booking->status == 'cancelled') bg-red-200 text-red-800 @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                        {{-- Harga --}}
                        <p class="font-semibold text-lg mb-2">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        {{-- Tombol Aksi --}}
                        <a href="{{ route('bookings.show', $booking) }}" class="inline-block bg-orange-500 text-white font-bold py-2 px-4 rounded-lg text-sm hover:bg-orange-600">
                            View Detail
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination Links --}}
             <div class="mt-8">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection