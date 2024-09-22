<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\SearchHistory;
use Illuminate\Support\Facades\Log;

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

        try {
            if (Cache::has($cacheKey)) {
                $weatherData = Cache::get($cacheKey);
            } else {
                $currentWeather = $this->getCurrentWeather($city, $country);
                $forecast = $this->getForecast($city, $country);

                $weatherData = [
                    'current' => $currentWeather,
                    'forecast' => $forecast
                ];

                Cache::put($cacheKey, $weatherData, now()->addMinutes(30));

                SearchHistory::create([
                    'city' => $city,
                    'country' => $country,
                    'weather_data' => $weatherData,
                ]);
            }

            return view('weather.result', compact('weatherData', 'city', 'country'));
        } catch (\Illuminate\Http\Client\RequestException $e) {
            Log::error('API request failed: ' . $e->getMessage());
            return back()->withError('Unable to fetch weather data. The weather service might be unavailable.');
        } catch (\Exception $e) {
            Log::error('Unexpected error: ' . $e->getMessage());
            return back()->withError('An unexpected error occurred. Please try again later.');
        }
    }

    public function showSavedWeather($id)
    {
        $searchHistory = SearchHistory::findOrFail($id);
        $weatherData = $searchHistory->weather_data;
        $city = $searchHistory->city;
        $country = $searchHistory->country;

        return view('weather.result', compact('weatherData', 'city', 'country'));
    }

    private function getCurrentWeather($city, $country)
    {
        $response = Http::timeout(15)->get($this->baseUrl . 'current', [
            'key' => $this->apiKey,
            'city' => $city,
            'country' => $country,
        ]);

        if ($response->successful()) {
            return $response->json()['data'][0];
        }

        throw new \Exception('Failed to fetch current weather: ' . $response->body());
    }

    private function getForecast($city, $country)
    {
        $response = Http::timeout(15)->get($this->baseUrl . 'forecast/daily', [
            'key' => $this->apiKey,
            'city' => $city,
            'country' => $country,
            'days' => 5,
        ]);

        if ($response->successful()) {
            return $response->json()['data'];
        }

        throw new \Exception('Failed to fetch forecast: ' . $response->body());
    }

    public function getHistory()
    {
        $searchHistory = SearchHistory::orderBy('created_at', 'desc')->paginate(10);
        return view('weather.history', compact('searchHistory'));
    }
}
