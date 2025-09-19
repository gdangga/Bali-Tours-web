@extends('layouts.admin')

@section('title', 'Dashboard Monitoring')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-orange-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Total Paket Tour</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $packageCount }}</p>
                </div>
                <div class="text-orange-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                </div>
            </div>
            <a href="{{ route('admin.packages.index') }}" class="text-sm text-orange-600 hover:underline mt-4 block">Lihat Detail &rarr;</a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Total Mobil</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $carCount }}</p>
                </div>
                <div class="text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17l6-6-6-6m-4 12V5a2 2 0 012-2h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2z" /></svg>
                </div>
            </div>
            <a href="{{ route('admin.cars.index') }}" class="text-sm text-blue-600 hover:underline mt-4 block">Lihat Detail &rarr;</a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Total Addons</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $addonCount }}</p>
                </div>
                <div class="text-green-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                </div>
            </div>
            <a href="{{ route('admin.addons.index') }}" class="text-sm text-green-600 hover:underline mt-4 block">Lihat Detail &rarr;</a>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-purple-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Total Bookingan</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $bookingCount }}</p>
                </div>
                <div class="text-purple-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                </div>
            </div>
             <a href="#" class="text-sm text-purple-600 hover:underline mt-4 block">Lihat Detail &rarr;</a>
        </div>

    </div>
@endsection