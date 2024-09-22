<!-- resources/views/weather/history.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Search History</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Weather Search History</h1>
        
        <ul>
            @foreach($searchHistory as $search)
                <li class="mb-2">
                    <a href="{{ route('weather.saved', $search->id) }}" class="text-blue-500 hover:underline">
                        {{ $search->city }}, {{ $search->country }} - {{ $search->created_at->format('Y-m-d H:i:s') }}
                    </a>
                </li>
            @endforeach
        </ul>

        {{ $searchHistory->links() }}

        <a href="{{ route('home') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Back to Search</a>
    </div>
</body>
</html>
