@extends('layouts.public')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-6 lg:px-20"
         x-data="{
             // Ambil data dari server dan siapkan untuk Alpine.js
             cartItems: {{ Js::from($cartItems->map(fn($item) => ['id' => $item->id, 'price' => $item->total_price])) }},
             
             // Simpan ID item yang terpilih. Defaultnya, pilih semua.
             selectedItems: {{ Js::from($cartItems->pluck('id')) }},

             // Hitung total harga dari item yang terpilih secara dinamis
             get selectedTotal() {
                 return this.cartItems
                     .filter(item => this.selectedItems.includes(item.id))
                     .reduce((sum, item) => sum + parseFloat(item.price), 0);
             }
         }">

        <h1 class="text-3xl font-bold text-gray-800 mb-8">My Cart</h1>

        @if($cartItems->isEmpty())
            <div class="bg-white p-8 rounded-lg shadow-md text-center">
                <p class="text-gray-600 text-lg">Your Cart is Empty.</p>
                <a href="{{ route('landing') }}#packages" class="mt-4 inline-block bg-orange-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-orange-600">
                    Browse Packages
                </a>
            </div>
        @else
            {{-- Tambahkan tag <form> untuk membungkus semuanya --}}
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- Daftar Item --}}
                    <div class="lg:col-span-2 space-y-6">
                        @foreach($cartItems as $item)
                        <div class="bg-white p-4 rounded-lg shadow-md flex items-start space-x-4">
                            {{-- Checkbox --}}
                            <input type="checkbox" name="cart_item_ids[]" value="{{ $item->id }}"
                                   x-model="selectedItems"
                                   class="mt-1 h-5 w-5 rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                            
                            <img src="{{ Storage::url($item->package->thumbnail) }}" alt="{{ $item->package->name }}" class="w-32 h-24 object-cover rounded-md">
                            <div class="flex-grow">
                                <h2 class="font-bold text-lg">{{ $item->package->name }}</h2>
                                <p class="text-sm text-gray-600">{{ $item->package_option->name }}</p>
                                <p class="text-sm text-gray-500">Date: {{ \Carbon\Carbon::parse($item->tour_date)->format('d F Y') }}</p>
                                <p class="text-sm text-gray-500">{{ $item->num_people }} Pax</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-lg">Rp {{ number_format($item->total_price, 0, ',', '.') }}</p>
                                {{-- Tombol Hapus tetap di form terpisah --}}
                                <a href="{{ route('cart.destroy', $item) }}" class="text-red-500 hover:text-red-700 text-sm font-semibold mt-2 inline-block">Delete</a>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Ringkasan --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white p-6 rounded-lg shadow-md sticky top-28">
                            <h3 class="text-xl font-bold border-b pb-4 mb-4">Summary</h3>
                            <div class="flex justify-between font-bold text-2xl">
                                <span>Total</span>
                                {{-- Tampilkan total dinamis dari Alpine.js --}}
                                <span x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(selectedTotal)"></span>
                            </div>
                            <button type="submit"
                                    class="mt-6 w-full text-white font-bold py-3 px-4 rounded-lg transition-colors"
                                    :class="selectedItems.length > 0 ? 'bg-orange-500 hover:bg-orange-600' : 'bg-gray-400 cursor-not-allowed'"
                                    :disabled="selectedItems.length === 0">
                                Continue to Booking
                            </button>
                            <p x-show="selectedItems.length === 0" class="text-center text-sm text-red-500 mt-2">
                                Please select at least one item.
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection