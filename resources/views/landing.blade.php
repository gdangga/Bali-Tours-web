@extends('layouts.public')

@section('content')
    <div id="home" class="hero-pattern text-white py-20 h-[500px] ">
        <div class="container mx-auto px-6 text-center ">
            <h1 class="text-4xl md:text-5xl font-bold mb-6" data-aos="fade-up">Discover Bali with Putra, <span class="text-orange-400">Your Friendly Local Driver</span></h1>
            <p class="text-xl mb-10" data-aos="fade-up" data-aos-delay="200">Putra Bali Tour offers safe, clean, and comfortable rides at affordable prices making every trip memorable and worry-free.</p>
            
            <div class="flex flex-col md:flex-row justify-center items-center space-y-4 md:space-y-0 md:space-x-4" data-aos="fade-up" data-aos-delay="400">
                <a href="#packages" class="bg-orange-500 text-white font-bold py-3 px-8 rounded-full text-lg">
                    Start Your Journey <i class="fas fa-arrow-right ml-2"></i>
                </a>
                <a href="#testimonials" class="bg-transparent border-2 border-white text-white font-bold py-3 px-8 rounded-full text-lg">
                    <i class="fas fa-play-circle mr-2"></i> See Testimonials
                </a>
            </div>
        </div>
    </div>

    <div class="py-16 bg-orange-50">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12" data-aos="fade-up">Hello There!</h2>
            
            <div class="flex flex-col items-center text-center space-y-8" data-aos="fade-up">
                <div class="flex justify-center">
                    <img class="rounded-full w-60 h-60 object-cover mx-auto" src="{{ asset('storage/image/WhatsApp Image 2024-02-14 at 09.56.26 (6).jpeg') }}" alt="Foto 1">
                </div>
                <div class="max-w-4xl">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Om Swastyastu, Warm regards From Bali</h3>
                    <p class="text-gray-600">Hi, I’m Nyoman Putra, you can call me Putra. I’m a tourism driver in Bali with 28 years of experience in the Bali Driver tourism. Putra Bali Tour offers transportation for tours in Bali, we have good services such as maintained vehicle cleanliness, professional and friendly drivers who will certainly make you comfortable. For all questions, you can directly click the “Book Now” button above.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-16 bg-white">
        <div class="container mx-auto px-6 ">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12" data-aos="fade-up">Why Choose Us?</h2>
            
            {{-- Perubahan: m-10 menjadi lg:mx-10 --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 lg:mx-10">
                <div class="bg-orange-50 p-8 rounded-xl text-center card-hover" data-aos="fade-up">
                    <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6"><i class="fas fa-tag text-orange-600 text-2xl"></i></div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Affordable Price</h3>
                    <p class="text-gray-600">Get the best deals with competitive rates.</p>
                </div>
                
                <div class="bg-orange-50 p-8 rounded-xl text-center card-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6"><i class="fas fa-shield-alt text-orange-600 text-2xl"></i></div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Safe and Comfortable</h3>
                    <p class="text-gray-600">Your journey will be guided by professional drivers with clean and well maintained vehicles.</p>
                </div>
                
                <div class="bg-orange-50 p-8 rounded-xl text-center card-hover" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6"><i class="fas fa-globe-asia text-orange-600 text-2xl"></i></div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Custom Destinations</h3>
                    <p class="text-gray-600">Access the best tourist spots you may have never visited before.</p>
                </div>
            </div>
        </div>
    </div>

    <div id="packages" class="py-16 bg-orange-50">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8" data-aos="fade-up">Our Service</h2>

            @if($categories->isEmpty())
                <p class="text-center text-gray-500" data-aos="fade-up">Saat ini belum ada paket wisata yang tersedia.</p>
            @else
                @foreach ($categories as $category)
                    {{-- Perubahan: m-10 menjadi lg:mx-10 --}}
                    <div class="mb-12 lg:mx-10" data-aos="fade-up">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6">{{ $category->name }}</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach ($category->packages as $package)
                                <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                                    <img src="{{ Storage::url($package->thumbnail) }}" alt="{{ $package->name }}" class="w-full h-56 object-cover">
                                    <div class="p-6">
                                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $package->name }}</h3>
                                        <p class="text-gray-600 text-lg font-semibold mb-4">
                                            Start From <span class="text-orange-600">Rp {{ number_format($package->starting_from_price, 0, ',', '.') }}</span>
                                        </p>
                                        <a href="{{ route('packages.show', $package) }}" class="inline-block bg-orange-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-orange-600 transition-colors duration-300">
                                            Read More
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div id="testimonials" class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8" data-aos="fade-up">What Our Guests Say?</h2>
            
            @if($reviews->isEmpty())
                <p class="text-center text-gray-500">Belum ada testimoni.</p>
            @else
                <div class="swiper testimonial-swiper lg:mx-10 pb-12" data-aos="fade-up">
                    <div class="swiper-wrapper">
                        @foreach($reviews as $review)
                        <div class="swiper-slide h-auto">
                            <div class="bg-orange-50 p-6 rounded-xl h-full flex flex-col">
                                <div class="flex items-center mb-4">
                                    <img src="{{ $review->user_thumbnail }}" alt="{{ $review->user_name }}" class="w-12 h-12 rounded-full object-cover">
                                    <div class="ml-4">
                                        <h4 class="font-bold text-gray-800">{{ $review->user_name }}</h4>
                                        <div class="flex text-yellow-400">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-600 italic flex-grow">"{{ Str::limit($review->snippet, 150) }}"</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="swiper-pagination mt-8 relative "></div>
                </div>
            @endif

            <div class="text-center mt-12" data-aos="fade-up">
                <a href="https://maps.app.goo.gl/QrdQmmgANnCinhGBA" 
                target="_blank" 
                class="inline-block bg-orange-500 text-white font-bold py-3 px-8 rounded-lg hover:bg-orange-600 transition-colors duration-300">
                    Give Us Review
                </a>
            </div>
        </div>
    </div>

    <div id="Contact" class="py-16 bg-orange-600 text-white" id="contact" data-aos="fade-up">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-6">Contact Us</h2>
            <p class="text-xl text-center mb-10">Have question about tour or transport in Bali? Let's send your messege now!</p>
            
            <div class="grid md:grid-cols-2 gap-10 max-w-6xl mx-auto">
                <div>   
                    <form class="space-y-4">
                        <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 md:w-2">
                            <input type="text" placeholder="Nama" class="flex-grow py-3 px-6 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-orange-300">
                            <input type="email" placeholder="Email" class="flex-grow py-3 px-6 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-orange-300">
                        </div>
                        <textarea rows="4" placeholder="Text your Question here" class="w-full py-3 px-6 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-orange-300"></textarea>
                        <button type="button" class="bg-white text-orange-600 font-bold py-3 px-8 rounded-lg hover:bg-orange-100 transition-colors duration-300">Send</button>
                    </form>
                </div>
                <div class="flex justify-center items-start">
                    <div class="w-full max-w-lg bg-white rounded-xl shadow-lg p-4">
                        <div id="fb-root"></div>
                        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v18.0" nonce="cq9iQrU1"></script>
                        <div class="fb-page" data-href="https://web.facebook.com/putrabalitourdriver" data-tabs="timeline" data-width="500" data-height="500" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                            <blockquote cite="https://web.facebook.com/putrabalitourdriver" class="fb-xfbml-parse-ignore">
                                <a href="https://web.facebook.com/putrabalitourdriver">Putra Bali Tour</a>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection