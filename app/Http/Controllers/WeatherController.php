<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\SearchHistory;

class WeatherController extends Controller
{
    private $apiKey;
    private $baseUrl = 'https://api.weatherbit.io/v2.0/';

    public function __construct()
    {
        $this->apiKey = config('services.weatherbit.key');
    }

    public function index()
    {
        $recentSearches = SearchHistory::orderBy('created_at', 'desc')->take(5)->get();
        return view('weather.index', compact('recentSearches'));
    }

    public function getWeather(Request $request)
    {
        $request->validate([
            'city' => 'required|string',
            'country' => 'required|string|size:2',
        ]);

        $city = $request->input('city');
        $country = $request->input('country');

        $cacheKey = "weather_{$city}_{$country}";

        // Check if the data is in the cache
        if (Cache::has($cacheKey)) {
            $weatherData = Cache::get($cacheKey);
        } else {
            try {
                $currentWeather = $this->getCurrentWeather($city, $country);
                $forecast = $this->getForecast($city, $country);

                $weatherData = [
                    'current' => $currentWeather,
                    'forecast' => $forecast
                ];

                // Cache the data for 30 minutes
                Cache::put($cacheKey, $weatherData, now()->addMinutes(30));

                // Store the search in history
                SearchHistory::create([
                    'city' => $city,
                    'country' => $country,
                ]);
            } catch (\Exception $e) {
                return back()->withError('Unable to fetch weather data. Please try again later.');
            }
        }

        return view('weather.result', compact('weatherData', 'city', 'country'));
    }

    private function getCurrentWeather($city, $country)
    {
        $response = Http::get($this->baseUrl . 'current', [
            'key' => $this->apiKey,
            'city' => $city,
            'country' => $country,
        ]);

        $response->throw();  // This will throw an exception for 4xx and 5xx errors

        return $response->json()['data'][0];
    }

    private function getForecast($city, $country)
    {
        $response = Http::get($this->baseUrl . 'forecast/daily', [
            'key' => $this->apiKey,
            'city' => $city,
            'country' => $country,
            'days' => 5,
        ]);

        $response->throw();

        return $response->json()['data'];
    }

    public function getHistory()
    {
        $searchHistory = SearchHistory::orderBy('created_at', 'desc')->paginate(10);
        return view('weather.history', compact('searchHistory'));
    }
}
