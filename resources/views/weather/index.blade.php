<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroWeather App</title>
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
            <h1 class="text-4xl md:text-5xl font-bold text-agro-brown mb-2">AgroWeather App</h1>
            <p class="text-agro-green text-lg">Your farming companion for weather updates</p>
        </header>
        
        <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 mb-8">
            <form action="{{ route('weather.get') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="city" class="block text-agro-brown font-semibold mb-2">City:</label>
                    <input type="text" id="city" name="city" required class="w-full p-3 border border-green-300 rounded-md focus:ring-2 focus:ring-agro-green focus:border-transparent">
                </div>
                <div>
                    <label for="country" class="block text-agro-brown font-semibold mb-2">Country Code:</label>
                    <input type="text" id="country" name="country" required class="w-full p-3 border border-green-300 rounded-md focus:ring-2 focus:ring-agro-green focus:border-transparent" maxlength="2">
                </div>
                <button type="submit" class="w-full bg-agro-green text-white font-bold py-3 px-4 rounded-md hover:bg-green-600 transition duration-300 ease-in-out transform hover:scale-105">
                    Get Weather
                </button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">
            <h2 class="text-2xl font-bold text-agro-brown mb-4">Recent Searches</h2>
            <ul class="space-y-2">
                @foreach($recentSearches as $search)
                    <li class="flex items-center space-x-2">
                        <span class="text-agro-green">•</span>
                        <span>{{ $search->city }}, {{ $search->country }} - {{ $search->created_at->diffForHumans() }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</body>
</html>
