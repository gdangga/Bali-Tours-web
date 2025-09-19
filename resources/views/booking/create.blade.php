@extends('layouts.public')

@section('content')
<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-6 lg:px-32">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Booking Confirmation</h1>

        {{-- Kode Alpine.js di dalam x-data HARUS berada dalam satu baris --}}
        <form method="POST" action="{{ route('booking.store') }}" 
            x-ref="bookingForm"
            x-data="{ packageOptions: {{ Js::from($package->options) }}, pricingType: '{{ $package->pricing_type }}', selectedOptionId: {{ old('package_option_id', $selectedData['option_id'] ?? 'null') }}, numPeople: {{ old('num_people', $selectedData['num_people'] ?? 1) }}, participants: [], paymentMethod: 'cash', isModalOpen: false, isProcessing: false, get selectedOptionPrice() { const option = this.packageOptions.find(o => o.id == this.selectedOptionId); return option ? parseFloat(option.price) : 0; }, get totalPrice() { if (this.pricingType === 'per_person') { return this.selectedOptionPrice * this.numPeople; } return this.selectedOptionPrice; }, syncParticipants() { const currentCount = this.participants.length; if (this.numPeople > currentCount) { for (let i = 0; i < this.numPeople - currentCount; i++) { this.participants.push({ name: '', age: '' }); } } else if (this.numPeople < currentCount) { this.participants.splice(this.numPeople); } }, handleOnlinePayment() { this.isProcessing = true; const formData = new FormData(this.$refs.bookingForm); fetch('{{ route('booking.pay') }}', { method: 'POST', headers: { 'Accept': 'application/json' }, body: formData }).then(response => { if (!response.ok) { return response.json().then(err => { throw err; }); } return response.json(); }).then(data => { if (data.snap_token) { snap.pay(data.snap_token, { onSuccess: function(result){ Swal.fire({ icon: 'success', title: 'Payment Success!', text: 'Your booking has been confirmed.', showConfirmButton: false, timer: 2000 }).then(() => window.location.href = '{{ route('bookings.index') }}'); }, onPending: function(result){ Swal.fire({ icon: 'info', title: 'Waiting for Payment', text: 'Please complete your payment.'}); }, onError: function(result){ Swal.fire({ icon: 'error', title: 'Payment Failed', text: 'Something went wrong. Please try again.'}); } }); } else { Swal.fire({ icon: 'error', title: 'Oops...', text: data.message || 'Failed to get payment token.'}); } this.isProcessing = false; }).catch(error => { console.error('Error:', error); let errorHtml = 'An unknown error occurred. Please try again.'; if (error.errors) { errorHtml = '<ul class=\'text-left list-disc list-inside\'>'; for (const key in error.errors) { errorHtml += `<li>${error.errors[key][0]}</li>`; } errorHtml += '</ul>'; } else if (error.message) { errorHtml = error.message; } Swal.fire({ icon: 'error', title: 'Request Error', html: errorHtml }); this.isProcessing = false; }); } }"
            x-init="syncParticipants()">

            @csrf
            <input type="hidden" name="package_id" value="{{ $package->id }}">
            <input type="hidden" name="total_price" :value="totalPrice">
            <input type="hidden" name="participants" :value="JSON.stringify(participants)">
            <input type="hidden" name="payment_method" x-model="paymentMethod">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                {{-- LEFT COLUMN: DETAILS & FORM --}}
                <div class="lg:col-span-2 bg-white p-8 rounded-lg shadow-md">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $package->name }}</h2>
                    <hr class="my-6">

                    <h3 class="text-xl font-semibold mb-4">1. Select Package Option</h3>
                    <div class="space-y-4 mb-6">
                        @foreach($package->options as $option)
                        <label class="flex p-4 border rounded-lg cursor-pointer transition-all" :class="{ 'bg-orange-50 border-orange-500 ring-2 ring-orange-400': selectedOptionId == {{ $option->id }} }">
                            <input type="radio" name="package_option_id" value="{{ $option->id }}" x-model.number="selectedOptionId" class="h-5 w-5 mt-1 text-orange-600">
                            <div class="ml-4 flex-grow">
                                <span class="font-bold text-lg">{{ $option->name }}</span>
                                <p class="text-sm text-gray-500">{{ $option->description }}</p>
                            </div>
                            <p class="text-xl font-bold text-gray-800 ml-4">Rp {{ number_format($option->price) }}</p>
                        </label>
                        @endforeach
                    </div>

                    <h3 class="text-xl font-semibold mb-4 mt-8">2. Trip Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="tour_date" class="block font-medium text-gray-700 mb-1">Date</label>
                            <input type="date" name="tour_date" id="tour_date" value="{{ old('tour_date', $selectedData['tour_date']) }}" class="w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label for="num_people" class="block font-medium text-gray-700 mb-1">Number of People</label>
                            <input type="number" name="num_people" id="num_people" min="1" x-model.number="numPeople" @input="syncParticipants" class="w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label for="pickup_time" class="block font-medium text-gray-700 mb-1">Pickup Time</label>
                            <input type="time" name="pickup_time" id="pickup_time" value="{{ old('pickup_time', '08:00') }}" class="w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                    </div>
                    <div>
                        <label for="pickup_location" class="block font-medium text-gray-700 mb-1">Pickup Location</label>
                        <textarea name="pickup_location" id="pickup_location" rows="3" class="w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g., Hotel name and address, Airport, etc." required>{{ old('pickup_location') }}</textarea>
                    </div>
                    
                    <h3 class="text-xl font-semibold mb-4 mt-8">3. Pax Details</h3>
                    <div class="space-y-4">
                        <template x-for="(participant, index) in participants" :key="index">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b pb-4">
                                <span class="font-semibold md:col-span-1" x-text="'Pax ' + (index + 1)"></span>
                                <div class="md:col-span-2 grid grid-cols-2 gap-4">
                                    <input type="text" x-model="participant.name" placeholder="Full Name" class="w-full rounded-md border-gray-300 shadow-sm text-sm" required>
                                    <input type="number" x-model.number="participant.age" placeholder="Age" class="w-full rounded-md border-gray-300 shadow-sm text-sm" required>
                                </div>
                            </div>
                        </template>
                    </div>

                    <h3 class="text-xl font-semibold mb-4 mt-8">4. Additional Notes</h3>
                    <div>
                        <label for="notes" class="block font-medium text-gray-700 mb-1">Have any special requests?</label>
                        <textarea name="notes" id="notes" rows="4" class="w-full rounded-md border-gray-300 shadow-sm" placeholder="Write your notes here..."></textarea>
                    </div>
                </div>

                {{-- RIGHT COLUMN: SUMMARY & ACTIONS --}}
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-lg shadow-md sticky top-28">
                        <h3 class="text-xl font-bold border-b pb-4 mb-4">Booking Summary</h3>
                        <div class="space-y-2 text-gray-600 mb-6">
                            <div class="flex justify-between">
                                <span>Price per unit</span>
                                <span class="font-semibold" x-text="new Intl.NumberFormat('id-ID').format(selectedOptionPrice)"></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Quantity</span>
                                <span class="font-semibold" x-text="pricingType === 'per_person' ? 'x ' + numPeople + ' person' : 'x 1 group'"></span>
                            </div>
                        </div>
                        <div class="flex justify-between font-bold text-xl border-t pt-4">
                            <span>Total Price</span>
                            <span class="text-orange-600" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(totalPrice)"></span>
                        </div>
                        
                        <div class="mt-8 space-y-4">
                             <button type="submit" formaction="{{ route('cart.add') }}" class="w-full text-center bg-orange-100 text-orange-600 font-bold py-3 px-4 rounded-lg hover:bg-orange-200 transition-colors border border-orange-500" :disabled="!selectedOptionId">
                                Add to Cart
                            </button>
                            <button type="button" @click.prevent="isModalOpen = true" class="w-full text-center text-white font-bold py-3 px-4 rounded-lg transition-colors" :class="{ 'bg-orange-500 hover:bg-orange-600': selectedOptionId, 'bg-gray-400 cursor-not-allowed': !selectedOptionId }" :disabled="!selectedOptionId">
                                Book Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PAYMENT MODAL --}}
            <div x-show="isModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
                <div @click.away="isModalOpen = false" class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
                    <div class="flex justify-between items-center border-b pb-3 mb-4">
                        <h3 class="text-2xl font-bold">Select Payment Method</h3>
                        <button @click="isModalOpen = false" class="text-gray-500 hover:text-gray-800 text-3xl leading-none">&times;</button>
                    </div>
                    <div class="space-y-4">
                        <button @click.prevent="$refs.bookingForm.action='{{ route('booking.store') }}'; paymentMethod = 'cash'; $refs.bookingForm.submit()" class="w-full flex items-center p-4 border rounded-lg hover:bg-orange-50 hover:border-orange-500 transition-all">
                            <i class="fas fa-money-bill-wave text-green-500 text-2xl"></i>
                            <span class="ml-4 font-semibold text-lg">Cash</span>
                        </button>
                        <button type="button" @click="handleOnlinePayment()" :disabled="isProcessing" class="w-full flex items-center p-4 border rounded-lg hover:bg-orange-50 hover:border-orange-500 transition-all">
                            <i class="far fa-credit-card text-blue-500 text-2xl"></i>
                            <span class="ml-4 font-semibold text-lg" x-text="isProcessing ? 'Processing...' : 'Online Payment'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection