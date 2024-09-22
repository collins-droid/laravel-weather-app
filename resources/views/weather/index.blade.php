@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-green-100 to-green-300 min-h-screen">
    <div class="container mx-auto p-4 md:p-8 max-w-3xl">
        @include('includes.header-1')
        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 mb-12 transition-all duration-300 ease-in-out hover:shadow-2xl">
            <form action="{{ route('weather.get') }}" method="POST" x-data="{ loading: false }" @submit="loading = true" class="space-y-6">
                @csrf
                <div>
                    <label for="city" class="block text-agro-brown font-semibold mb-2">City:</label>
                    <input type="text" id="city" name="city" required class="w-full p-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-300 ease-in-out">
                </div>
                <div>
                    <label for="country" class="block text-agro-brown font-semibold mb-2">Country Code:</label>
                    <input type="text" id="country" name="country" required class="w-full p-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-300 ease-in-out" maxlength="2">
                </div>
                <button type="submit" class="w-full bg-agro-green text-white font-bold py-4 px-6 rounded-lg hover:bg-green-600 transition-all duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-agro-green" x-bind:disabled="loading">
                    <span x-show="!loading">Get Weather</span>
                    <span x-show="loading" class="flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Loading...
                    </span>
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 transition-all duration-300 ease-in-out hover:shadow-2xl">
            <h2 class="text-2xl font-bold text-agro-brown mb-6">Recent Searches</h2>
            <ul class="space-y-3">
                @foreach($recentSearches as $search)
                    <li class="mb-2 transition-all duration-300 ease-in-out hover:translate-x-2">
                        <a href="{{ route('weather.saved', $search->id) }}" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            {{ $search->city }}, {{ $search->country }} - {{ $search->created_at->diffForHumans() }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection