@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-green-100 to-green-300 min-h-screen">
    <div class="container mx-auto p-4 md:p-8 max-w-5xl">
       @include('includes.header-2')

        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 mb-12 transition-all duration-300 ease-in-out hover:shadow-2xl">
            <h2 class="text-2xl md:text-3xl font-bold text-agro-brown mb-6">Current Weather</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center p-4 bg-green-50 rounded-lg transition-all duration-300 ease-in-out hover:shadow-md">
                    <p class="text-3xl font-semibold text-agro-green mb-2">{{ $weatherData['current']['temp'] }}°C</p>
                    <p class="text-sm text-gray-600">Temperature</p>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg transition-all duration-300 ease-in-out hover:shadow-md">
                    <p class="text-3xl font-semibold text-agro-green mb-2">{{ $weatherData['current']['app_temp'] }}°C</p>
                    <p class="text-sm text-gray-600">Feels Like</p>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg transition-all duration-300 ease-in-out hover:shadow-md">
                    <p class="text-3xl font-semibold text-agro-green mb-2">{{ $weatherData['current']['wind_spd'] }} m/s</p>
                    <p class="text-sm text-gray-600">Wind Speed</p>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg transition-all duration-300 ease-in-out hover:shadow-md col-span-2 md:col-span-1">
                    <p class="text-xl font-semibold text-agro-green mb-2">{{ $weatherData['current']['weather']['description'] }}</p>
                    <p class="text-sm text-gray-600">Description</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 mb-12 transition-all duration-300 ease-in-out hover:shadow-2xl">
            <h2 class="text-2xl md:text-3xl font-bold text-agro-brown mb-6">5-Day Forecast</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                @foreach($weatherData['forecast'] as $day)
                    <div class="border border-green-200 p-4 rounded-lg hover:shadow-md transition-all duration-300 ease-in-out hover:scale-105 bg-green-50">
                        <h3 class="font-bold text-agro-brown text-lg mb-2">{{ \Carbon\Carbon::parse($day['datetime'])->format('D, M d') }}</h3>
                        <p class="text-agro-green font-semibold">High: {{ $day['max_temp'] }}°C</p>
                        <p class="text-agro-green font-semibold">Low: {{ $day['min_temp'] }}°C</p>
                        <p class="text-sm text-gray-600 mt-2">{{ $day['weather']['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('home') }}" class="inline-block bg-agro-green text-white font-bold py-4 px-8 rounded-lg hover:bg-green-600 transition-all duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-agro-green">
                Back to Search
            </a>
        </div>
    </div>
</div>

@endsection