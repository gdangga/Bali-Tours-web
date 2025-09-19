@extends('layouts.public')

@section('content')
{{-- Tambahkan script Alpine.js jika belum ada di layout utama Anda --}}
<script src="//unpkg.com/alpinejs" defer></script>

<div class="bg-white">
    <div class="container mx-auto px-6 lg:px-32 py-12">
        <div data-aos="fade-up">
                    @if($package->category)
                        <span class="text-orange-600 font-semibold">{{ $package->category->name }}</span>
                    @endif
                    <h1 class="text-4xl font-bold text-gray-800 my-2">{{ $package->name }}</h1>
                    <hr class="my-6">
                </div>
        {{-- Galeri Gambar dengan animasi fade-up --}}
        <div x-data="{ modalOpen: false }" data-aos="fade-up">
            <div class="bg-transparent grid grid-cols-2 md:grid-cols-4 gap-1 mb-8 overflow-hidden rounded-xl">
                <div class="col-span-2 row-span-2 aspect-video">
                    <img src="{{ Storage::url($package->thumbnail) }}" 
                         alt="{{ $package->name }}" 
                         class="w-full h-full object-cover rounded-xl">
                </div>
                @foreach ($package->images->take(3) as $image)
                    <div class="col-span-1 row-span-1 aspect-video">
                        <img src="{{ Storage::url($image->image_path) }}" 
                             alt="Galeri {{ $loop->iteration }}" 
                             class="w-full h-full object-cover rounded-xl">
                    </div>
                @endforeach
                @if ($package->images->count() > 3)
                    <div class="col-span-1 row-span-1 relative aspect-video">
                        <img src="{{ Storage::url($package->images[3]->image_path) }}" 
                             alt="Galeri 4" 
                             class="w-full h-full object-cover rounded-xl">
                        
                        @if ($package->images->count() > 4)
                            <div 
                                @click="modalOpen = true" 
                                class="absolute inset-0 flex items-center justify-center cursor-pointer rounded-xl hover:bg-opacity-60 transition-all bg-black/50">
                                <span class="text-white text-xl font-bold">+{{ $package->images->count() - 4 }} more</span>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Modal (tidak perlu animasi AOS karena sudah ada transisi dari Alpine.js) --}}
            <div 
                x-show="modalOpen" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 flex items-center justify-center p-4"
                style="display: none; background: #00000066;"
            >
                <button @click="modalOpen = false" class="absolute top-4 right-4 text-white text-4xl z-50">×</button>
                <div @click.away="modalOpen = false" class="bg-white rounded-lg max-w-4xl max-h-[90vh] w-full p-6 overflow-y-auto">
                    <h2 class="text-2xl font-bold mb-4">Galeri: {{ $package->name }}</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach ($package->images as $image)
                            <img src="{{ Storage::url($image->image_path) }}" 
                                 alt="Galeri Lengkap {{ $loop->iteration }}" 
                                 class="w-full h-auto object-cover rounded-lg shadow-md">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Konten Utama dengan Harga Dinamis --}}
        <div 
            class="grid grid-cols-1 lg:grid-cols-3 gap-12"
            x-data="{ 
                selectedOptionId: null, 
                selectedOptionPrice: 0,
                numPeople: 1,  // <-- TAMBAHKAN: Untuk melacak jumlah orang, default 1
                totalPrice: 0, // <-- TAMBAHKAN: Untuk menyimpan harga total
                pricingType: '{{ $package->pricing_type }}' // <-- TAMBAHKAN: Untuk mengetahui tipe harga
            }"
            x-effect="
                if (pricingType === 'per_person') {
                    totalPrice = selectedOptionPrice * numPeople;
                } else {
                    totalPrice = selectedOptionPrice;
                }
            "
        >
            {{-- KOLOM KIRI --}}
            <div class="lg:col-span-2">
                
                
                @if($package->highlights)
                <div class="mb-6" data-aos="fade-up">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Sorotan Utama</h2>
                    <div class="prose max-w-none text-gray-600">
                        {!! $package->highlights !!}
                    </div>
                </div>
                <hr class="my-6" data-aos="fade-up">
                @endif

                <div data-aos="fade-up">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Deskripsi Lengkap</h2>
                    <div class="prose max-w-none text-gray-600">
                        {!! $package->description !!}
                    </div>
                </div>
                <hr class="my-6" data-aos="fade-up">

                <div id="booking-options" data-aos="fade-up">
                    <h2 class="text-2xl font-bold text-gray-800 mt-5 mb-4">Pilih Opsi Anda</h2>
                    
                    <form id="booking-form" action="#" method="POST">
                        @csrf
                        <input type="hidden" name="package_id" value="{{ $package->id }}">
                        
                        <div class="space-y-4 mb-6">
                            @forelse($package->options as $option)
                            <label 
                                for="option_{{ $option->id }}" 
                                class="flex p-4 border rounded-lg cursor-pointer transition-all"
                                :class="{ 'bg-orange-50 border-orange-500': selectedOptionId == {{ $option->id }} }"
                            >
                                <input 
                                    type="radio" 
                                    name="package_option_id" 
                                    value="{{ $option->id }}" 
                                    id="option_{{ $option->id }}" 
                                    class="h-5 w-5 mt-1 text-orange-600 border-gray-300 focus:ring-orange-500"
                                    :checked="selectedOptionId == {{ $option->id }}"
                                    @click="
                                        if (selectedOptionId === {{ $option->id }}) {
                                            selectedOptionId = null;
                                            selectedOptionPrice = 0;
                                        } else {
                                            selectedOptionId = {{ $option->id }};
                                            selectedOptionPrice = {{ $option->price }};
                                        }
                                    "
                                >
                                <div class="ml-4 flex flex-col flex-grow">
                                    <span class="font-bold text-lg text-gray-800">{{ $option->name }}</span>
                                    @if($option->description)
                                        <span class="text-sm text-gray-500 mt-1">{{ $option->description }}</span>
                                    @endif
                                    <span class="text-green-600 text-sm font-semibold mt-2">Pembatalan gratis tersedia</span>
                                </div>
                                <div class="text-right ml-4">
                                    <p class="text-sm text-gray-500">Harga</p>
                                    <p class="text-xl font-bold text-gray-800">Rp {{ number_format($option->price) }}</p>
                                    <p class="text-xs text-gray-500">per {{ $package->pricing_type == 'per_person' ? 'orang' : 'grup' }}</p>
                                </div>
                            </label>
                            @empty
                            <p class="text-sm text-gray-500">Tidak ada opsi tersedia untuk paket ini.</p>
                            @endforelse
                        </div>

                        @auth
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label for="tour_date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                                    <input type="date" name="tour_date" id="tour_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                </div>
                                <div>
                                    <label for="num_people" class="block text-sm font-medium text-gray-700 mb-1">Pax total</label>
                                    <input type="number" name="num_people" id="num_people" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required x-model.number="numPeople">
                                </div>
                            </div>
                             
                        @endauth
                    </form>
                </div>
                <hr class="my-6" data-aos="fade-up">
            </div>

            {{-- KOLOM KANAN: KOTAK TOTAL HARGA --}}
            <div class="lg:col-span-1" data-aos="fade-up">
                <div class="bg-gray-50 border p-6 rounded-lg shadow-md sticky top-28">
                    @auth
                        <p class="text-lg">Total Harga</p>
                        <p class="text-3xl font-bold text-gray-800 mb-4">
                            Rp <span x-text="new Intl.NumberFormat('id-ID').format(totalPrice)">0</span>
                        </p>

                        {{-- UBAH BUTTON MENJADI LINK (tag <a>) --}}
                        <a  :href="selectedOptionId ? `{{ route('booking.create') }}?package_id={{ $package->id }}&option_id=${selectedOptionId}&num_people=${numPeople}&tour_date=${document.getElementById('tour_date').value}` : '#'"
                            @click="if (!selectedOptionId) { event.preventDefault(); alert('Silakan pilih opsi paket terlebih dahulu.'); }"
                            class="w-full text-center text-white font-bold py-3 px-4 rounded-lg text-lg transition-colors inline-block"
                            :class="{
                                'bg-orange-500 hover:bg-orange-600': selectedOptionId !== null,
                                'bg-gray-400 cursor-not-allowed': selectedOptionId === null
                            }"
                        >
                            Book Now
                        </a>
                    @endauth
                    @guest
                        <div class="text-center">
                            <p class="text-lg font-semibold mb-4 text-gray-700">Login untuk Memesan</p>
                            <a href="{{ route('login') }}" class="w-full inline-block bg-orange-500 text-white font-bold py-3 px-4 rounded-lg hover:bg-orange-600 mb-1">
                                Login atau Register
                            </a>
                            <p class="text-lg font-semibold mb-1 text-gray-700">OR</p>
                            <a href="https://wa.me/6281337357345" target="_blank"
                                class="w-full inline-flex items-center justify-center gap-2 bg-green-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-green-700">
                                <i class="fab fa-whatsapp text-xl"></i>
                                Booking Via WhatsApp
                            </a>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection