@extends('layouts.admin')

@section('title', 'Detail Booking #' . $booking->id)

@section('content')
    <div class="bg-white p-6 md:p-8 rounded-lg shadow-md">
        <div class="flex flex-col md:flex-row justify-between md:items-center border-b pb-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Booking Detail: #{{ $booking->id }}</h2>
                <p class="text-sm text-gray-500">Booked on: {{ $booking->created_at->format('d F Y, H:i') }}</p>
            </div>
            @php
                $statusClasses = [
                    'pending' => 'bg-yellow-200 text-yellow-800', 'confirmed' => 'bg-blue-200 text-blue-800',
                    'completed' => 'bg-green-200 text-green-800', 'cancelled' => 'bg-red-200 text-red-800',
                ];
            @endphp
            <span class="px-3 py-1 mt-2 md:mt-0 text-md font-semibold rounded-full {{ $statusClasses[$booking->status] ?? '' }}">
                {{ ucfirst($booking->status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- KOLOM KIRI: DETAIL UTAMA --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- DETAIL PERJALANAN --}}
                <div class="p-4 border rounded-lg">
                    <h3 class="text-lg font-semibold mb-3 text-gray-700">Trip Details</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <p><strong>Package:</strong><br> {{ $booking->package->name }}</p>
                        <p><strong>Tour Date:</strong><br> {{ \Carbon\Carbon::parse($booking->tour_date)->format('d F Y') }}</p>
                        <p><strong>Pickup Time:</strong><br> {{ \Carbon\Carbon::parse($booking->pickup_time)->format('H:i') }}</p>
                        <p><strong>Total Pax:</strong><br> {{ $booking->num_people }} person</p>
                        <p class="col-span-2"><strong>Pickup Location:</strong><br> {{ $booking->pickup_location }}</p>
                    </div>
                </div>

                {{-- DETAIL PESERTA --}}
                <div class="p-4 border rounded-lg">
                    <h3 class="text-lg font-semibold mb-3 text-gray-700">Pax Details</h3>
                    @if(!empty($booking->participants))
                        <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach($booking->participants as $pax)
                            <li><strong>{{ $pax['name'] ?? 'N/A' }}</strong> - (Age: {{ $pax['age'] ?? 'N/A' }})</li>
                        @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-500">No pax details provided.</p>
                    @endif
                </div>

                {{-- CATATAN DARI PELANGGAN --}}
                @if($booking->notes)
                <div class="p-4 border rounded-lg">
                    <h3 class="text-lg font-semibold mb-2 text-gray-700">Customer Notes</h3>
                    <p class="text-sm text-gray-600 whitespace-pre-wrap">{{ $booking->notes }}</p>
                </div>
                @endif
                
                {{-- PESAN KONFIRMASI DARI ADMIN --}}
                @if($booking->pesan_confirm)
                <div class="p-4 bg-blue-50 border-l-4 border-blue-400 rounded-r-lg">
                    <h3 class="text-lg font-semibold mb-2 text-blue-800">Confirmation Message (from Admin)</h3>
                    <p class="text-sm text-blue-700 whitespace-pre-wrap">{{ $booking->pesan_confirm }}</p>
                </div>
                @endif
            </div>

            {{-- KOLOM KANAN: INFO PELANGGAN & UPDATE STATUS --}}
            <div class="space-y-6">
                {{-- INFO PELANGGAN --}}
                <div class="p-4 border rounded-lg">
                    <h3 class="text-lg font-semibold mb-3 text-gray-700">Customer Info</h3>
                    <div class="text-sm space-y-2">
                        <p><strong>Name:</strong><br> {{ $booking->user->name }}</p>
                        <p><strong>Email:</strong><br> {{ $booking->user->email }}</p>
                        <p><strong>Phone:</strong><br> {{ $booking->user->phone }}</p>
                    </div>
                </div>

                {{-- HARGA --}}
                <div class="p-4 border rounded-lg">
                    <h3 class="text-lg font-semibold mb-3 text-gray-700">Payment Details</h3>
                    <p class="text-2xl font-bold text-orange-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-500">via {{ ucfirst($booking->payment_method) }}</p>
                </div>

                {{-- UPDATE STATUS --}}
                <div class="p-4 border rounded-lg">
                    <h3 class="text-lg font-semibold mb-3 text-gray-700">Update Booking Status</h3>
                    <form id="statusForm" action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="pesan_confirm" id="pesan_confirm_input">
                        <div class="flex items-center space-x-2">
                            <select name="status" id="statusSelect" class="flex-grow shadow-sm border rounded py-2 px-3 text-gray-700">
                                <option value="pending" @selected($booking->status == 'pending')>Pending</option>
                                <option value="confirmed" @selected($booking->status == 'confirmed')>Confirmed</option>
                                <option value="completed" @selected($booking->status == 'completed')>Completed</option>
                                <option value="cancelled" @selected($booking->status == 'cancelled')>Cancelled</option>
                            </select>
                            <button type="submit" id="updateBtn" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-8 border-t pt-6">
            <a href="{{ route('admin.bookings.index') }}" class="text-blue-600 hover:underline">&larr; Back to Booking List</a>
        </div>
    </div>

    {{-- === KODE MODAL YANG HILANG DIMULAI DI SINI === --}}
    <div id="confirmationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center hidden">
        <div class="relative mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Add Confirmation Message</h3>
                <div class="mt-2 px-7 py-3">
                    <textarea id="pesan_confirm_textarea" class="w-full h-24 p-2 border rounded" placeholder="Example: Your booking is confirmed. Please be at the hotel lobby at 8 AM. Thank you!"></textarea>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="saveConfirmBtn" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600">
                        Save & Confirm Booking
                    </button>
                    <button id="closeModalBtn" class="mt-2 px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-300">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- === KODE MODAL BERAKHIR DI SINI === --}}

    {{-- SCRIPT UNTUK MODAL --}}
    <script>
        const statusForm = document.getElementById('statusForm');
        const statusSelect = document.getElementById('statusSelect');
        const modal = document.getElementById('confirmationModal');
        const saveConfirmBtn = document.getElementById('saveConfirmBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const pesanTextarea = document.getElementById('pesan_confirm_textarea');
        const pesanInput = document.getElementById('pesan_confirm_input');

        // Pastikan semua elemen ada sebelum menambahkan event listener
        if (statusForm && statusSelect && modal && saveConfirmBtn && closeModalBtn && pesanTextarea && pesanInput) {
            statusForm.addEventListener('submit', function(event) {
                // Jika status yang dipilih adalah 'confirmed', hentikan submit & tampilkan modal
                if (statusSelect.value === 'confirmed') {
                    event.preventDefault();
                    modal.classList.remove('hidden');
                }
                // Jika status lain, biarkan form tersubmit seperti biasa
            });

            // Tombol untuk menyimpan dari modal
            saveConfirmBtn.addEventListener('click', function() {
                // Salin isi textarea ke input form yang tersembunyi
                pesanInput.value = pesanTextarea.value;
                // Submit form utama
                statusForm.submit();
            });

            // Tombol untuk menutup modal
            closeModalBtn.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
        }
    </script>
@endsection