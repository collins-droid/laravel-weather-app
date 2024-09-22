<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroWeather Results for {{ $city }}, {{ $country }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'agro-green': '#2ecc71',
                        'agro-brown': '#8B4513',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-b from-green-100 to-green-200 min-h-screen">
    <div class="container mx-auto p-4 md:p-8">
        <header class="text-center mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-agro-brown mb-2">AgroWeather Results</h1>
            <p class="text-2xl md:text-3xl text-agro-green">{{ $city }}, {{ $country }}</p>
        </header>

        <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 mb-8">
            <h2 class="text-2xl font-bold text-agro-brown mb-4">Current Weather</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <p class="text-xl font-semibold text-agro-green">{{ $weatherData['current']['temp'] }}°C</p>
                    <p class="text-sm text-gray-600">Temperature</p>
                </div>
                <div class="text-center">
                    <p class="text-xl font-semibold text-agro-green">{{ $weatherData['current']['app_temp'] }}°C</p>
                    <p class="text-sm text-gray-600">Feels Like</p>
                </div>
                <div class="text-center">
                    <p class="text-xl font-semibold text-agro-green">{{ $weatherData['current']['wind_spd'] }} m/s</p>
                    <p class="text-sm text-gray-600">Wind Speed</p>
                </div>
                <div class="text-center col-span-2 md:col-span-1">
                    <p class="text-xl font-semibold text-agro-green">{{ $weatherData['current']['weather']['description'] }}</p>
                    <p class="text-sm text-gray-600">Description</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 mb-8">
            <h2 class="text-2xl font-bold text-agro-brown mb-4">5-Day Forecast</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach($weatherData['forecast'] as $day)
                    <div class="border border-green-200 p-4 rounded-lg hover:shadow-md transition duration-300">
                        <h3 class="font-bold text-agro-brown">{{ \Carbon\Carbon::parse($day['datetime'])->format('D, M d') }}</h3>
                        <p class="text-agro-green">High: {{ $day['max_temp'] }}°C</p>
                        <p class="text-agro-green">Low: {{ $day['min_temp'] }}°C</p>
                        <p class="text-sm text-gray-600 mt-2">{{ $day['weather']['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('home') }}" class="inline-block bg-agro-green text-white font-bold py-3 px-6 rounded-md hover:bg-green-600 transition duration-300 ease-in-out transform hover:scale-105">
                Back to Search
            </a>
        </div>
    </div>
</body>
</html>
