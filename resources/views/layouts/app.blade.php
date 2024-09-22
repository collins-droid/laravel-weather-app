<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'AgroWeather App' }}</title>
    
    {{-- Tailwind CSS and Alpine.js --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.3/cdn.min.js" defer></script>
    
    {{-- Tailwind Custom Configuration --}}
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

    {{-- Google Fonts --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>

    {{-- Custom Styles --}}
    @stack('styles')

</head>
<body class="bg-gradient-to-br from-green-100 to-green-300 min-h-screen">

    {{-- Main Content --}}
    <div class="container mx-auto p-4 md:p-8 max-w-5xl">
        @yield('content')
    </div>

      @stack('scripts')

</body>
</html>

