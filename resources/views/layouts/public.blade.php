<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Putra Bali Tour</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; scroll-behavior: smooth; }
        .hero-pattern {
            background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)),
                        url('/storage/image/WhatsApp Image 2024-02-14 at 09.56.26 (6).jpeg');
            background-size: cover;
            background-position: center;
            padding-top: 10%;
            }

            /* Untuk layar 742px ke bawah */
            @media (max-width: 742px) {
            .hero-pattern {
                background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                            url('/storage/image/WhatsApp Image 2024-02-14 at 09.56.26 (3).jpeg');
                background-size: cover;
                background-position: center;
            }
        }

        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-10px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
        .testimonial-swiper .swiper-pagination {
            position: relative; /* Mengubah posisi dari absolute menjadi relative */
            bottom: auto;       /* Menghapus properti 'bottom' bawaan Swiper */
            margin-top: 2rem;   /* Memberi jarak atas dari slider */
        }
    </style>
    {{-- {!! NoCaptcha::renderJs() !!} --}}
</head>
<script type="text/javascript" src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<body class="bg-orange-50">
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ asset('Logo PBT Transparantw.png') }}" class="h-10 mr-3" alt="Logo PBT" />
                <a href="{{ route('landing') }}" class="text-xl font-bold text-gray-800">Putra Bali Tour</a>
            </div>
            
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('landing') }}" class="text-gray-700 hover:text-orange-500">Home</a>
                <a href="{{ route('landing') }}#packages" class="text-gray-700 hover:text-orange-500">Service</a>
                <a href="{{ route('landing') }}#testimonials" class="text-gray-700 hover:text-orange-500">Testimonial</a>
                <a href="{{ route('landing') }}#Contact" class="text-gray-700 hover:text-orange-500">Contact</a>
                
                @guest
                    {{-- TAMPILAN UNTUK TAMU (BELUM LOGIN) --}}
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-500">Login</a>
                    <a href="{{ route('register') }}" class="bg-orange-500 text-white font-bold py-2 px-4 rounded hover:bg-orange-700">Daftar</a>
                @endguest

                @auth
                    {{-- TAMPILAN UNTUK USER (SUDAH LOGIN) --}}
                    <div class="flex items-center space-x-6">
                        {{-- NAMA PENGGUNA (Dua kata pertama) --}}
                        <span class="text-gray-700">Halo, {{ Str::words(Auth::user()->name, 2, '') }}</span>
                        
                        <div class="border-l h-6"></div>

                        {{-- KUMPULAN IKON AKSI --}}
                        <a href="{{ route('bookings.index') }}" title="My Bookings" class="text-gray-700 hover:text-orange-500 relative">
                            <i class="fas fa-receipt text-xl"></i>
                            @if($bookingCount > 0)
                                <span class="absolute -top-2 -right-2 bg-green-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">{{ $bookingCount }}</span>
                            @endif
                        </a>

                        <a href="{{ route('cart.index') }}" title="My Cart" class="text-gray-700 hover:text-orange-500 relative">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            @if($cartCount > 0)
                                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                            @endif
                        </a>
                        
                        <a href="{{ route('profile.edit') }}" title="My Profile" class="text-gray-700 hover:text-orange-500">
                            <i class="fas fa-user-circle text-xl"></i>
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" title="Logout" class="text-gray-700 hover:text-orange-500">
                                <i class="fas fa-sign-out-alt text-xl"></i>
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
            
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="outline-none">
                    <svg class="w-6 h-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>
        
        <div id="mobile-menu" class="hidden md:hidden">
            <div class="container mx-auto px-6 pt-2 pb-4">
                <a href="{{ route('landing') }}" class="block py-2 text-gray-700 hover:text-orange-500">Home</a>
                <a href="{{ route('landing') }}#packages" class="block py-2 text-gray-700 hover:text-orange-500">Service</a>
                <a href="{{ route('landing') }}#testimonials" class="block py-2 text-gray-700 hover:text-orange-500">Testimonial</a>
                <a href="{{ route('landing') }}#contact" class="block py-2 text-gray-700 hover:text-orange-500">Contact</a>
                <hr class="my-2">
                @guest
                    <a href="{{ route('login') }}" class="block py-2 text-gray-700 hover:text-orange-500">Login</a>
                    <a href="{{ route('register') }}" class="block py-2"><span class="bg-orange-500 text-white font-bold py-2 px-4 rounded inline-block mt-2">Daftar</span></a>
                @endguest
                @auth
                    <a href="{{ route('bookings.index') }}" class="block py-2 text-gray-700 hover:text-orange-500">
                        <i class="fas fa-receipt fa-fw mr-2"></i>My Bookings ({{ $bookingCount }})
                    </a>
                    <a href="{{ route('cart.index') }}" class="block py-2 text-gray-700 hover:text-orange-500">
                        <i class="fas fa-shopping-cart fa-fw mr-2"></i>My Cart ({{ $cartCount }})
                    </a>
                    <a href="{{ route('profile.edit') }}" class="block py-2 text-gray-700 hover:text-orange-500">
                        <i class="fas fa-user-circle fa-fw mr-2"></i>My Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block py-2 text-gray-700 hover:text-orange-500">
                            <i class="fas fa-sign-out-alt fa-fw mr-2"></i>Logout
                        </a>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-gray-300 pt-12">
        <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Logo & About --}}
            <div>
                <div class="flex items-center mb-4">
                    <img src="{{ asset('Logo PBT Transparantw.png') }}" class="h-12 mr-3" alt="Logo PBT" />
                    <h2 class="text-xl font-bold text-white">Putra Bali Tour</h2>
                </div>
                <p class="text-gray-400">
                    Discover the beauty of Bali with us!
                    Professional tour services for unforgettable experiences.
                </p>
            </div>

            {{-- Quick Links --}}
            <div>
                <h3 class="text-white font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('landing') }}#packages" class="hover:text-orange-400">Our Service</a></li>
                    <li><a href="{{ route('landing') }}#testimonials" class="hover:text-orange-400">Testimonial</a></li>
                    <li><a href="{{ route('landing') }}#contact" class="hover:text-orange-400">Contact</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-orange-400">Login</a></li>
                </ul>
            </div>

            {{-- Contact & Social --}}
            <div>
                <h3 class="text-white font-semibold mb-4">Contact Us</h3>
                <p><i class="fas fa-map-marker-alt mr-2 text-orange-400"></i> Badung, Bali</p>
                <p><i class="fas fa-phone mr-2 text-orange-400"></i> +62 8133 7357 345</p>
                <p><i class="fas fa-envelope mr-2 text-orange-400"></i> putrabalitoursgo@gmail.com</p>

                <div class="flex space-x-4 mt-4">
                    <a href="https://www.facebook.com/putrabalitourdriver" class="hover:text-orange-400"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="https://www.instagram.com/putrabali_drivers?igsh=MnloOHFwajM5MXQ1" class="hover:text-orange-400"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="https://wa.me/6281337357345" target="_blank" class="hover:text-orange-400"><i class="fab fa-whatsapp fa-lg"></i></a>
                </div>
            </div>
        </div>

    <div class="border-t border-gray-700 mt-10 py-6 text-center text-gray-400 text-sm">
        &copy; {{ date('Y') }} Putra Bali Tour. All rights reserved.
    </div>
</footer>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Inisialisasi AOS
        AOS.init({
            duration: 800, // Durasi animasi dalam milidetik
            once: true, // Animasi hanya berjalan sekali
        });
        const menuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        const swiper = new Swiper('.testimonial-swiper', {
            // Opsi untuk membuat slider berputar terus menerus
            loop: true,

            // Mengatur slide agar berjalan otomatis
            autoplay: {
                delay: 3000, // Jeda 3 detik sebelum pindah ke slide berikutnya
                disableOnInteraction: false, // Tetap auto-play setelah interaksi user
            },

            // Mengaktifkan navigasi titik-titik (pagination)
            pagination: {
                el: '.swiper-pagination',
                clickable: true, // Titik-titik bisa di-klik
            },

            // Mengatur jumlah slide yang tampil berdasarkan ukuran layar
            slidesPerView: 1, // Tampil 1 slide di layar kecil (default)
            spaceBetween: 20, // Jarak antar slide
            breakpoints: {
                // Jika lebar layar 768px atau lebih
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                // Jika lebar layar 1024px atau lebih
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 40,
                },
            },
        });

         @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 3000, // Pop-up will close automatically after 3 seconds
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}'
            });
        @endif
    </script>
</body>
</html>