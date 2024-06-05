<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GeocodingController extends Controller
{
    private $client;
    private $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('GEOCODING_API_KEY'); // Store your API key in the .env file
    }

    public function getByLatLng(Request $request)
    {
        $lat = $request->query('lat');
        $lng = $request->query('lng');

        if (!$lat || !$lng) {
            return response()->json(['error' => 'Latitude and longitude are required'], 400);
        }

        try {
            $response = $this->client->request('GET', 'https://map-geocoding.p.rapidapi.com/json', [
                'query' => [
                    'latlng' => "{$lat},{$lng}",
                ],
                'headers' => [
                    'X-RapidAPI-Host' => 'map-geocoding.p.rapidapi.com',
                    'X-RapidAPI-Key' => $this->apiKey,
                ],
            ]);

            $body = $response->getBody();
            Log::info('Geocoding API response: ' . $body);

            return response()->json(json_decode($body), 200);
        } catch (\Exception $e) {
            Log::error('Geocoding API error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function getByPlaceId(Request $request)
    {
        $placeId = $request->query('placeid');

        if (!$placeId) {
            return response()->json(['error' => 'Place ID is required'], 400);
        }

        try {
            $response = $this->client->request('GET', 'https://map-geocoding.p.rapidapi.com/json', [
                'query' => [
                    'place_id' => $placeId,
                ],
                'headers' => [
                    'X-RapidAPI-Host' => 'map-geocoding.p.rapidapi.com',
                    'X-RapidAPI-Key' => $this->apiKey,
                ],
            ]);

            $body = $response->getBody();
            Log::info('Geocoding API response: ' . $body);

            return response()->json(json_decode($body), 200);
        } catch (\Exception $e) {
            Log::error('Geocoding API error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function getByAddress(Request $request)
    {
        $address = $request->query('address');

        if (!$address) {
            return response()->json(['error' => 'Address is required'], 400);
        }

        try {
            $response = $this->client->request('GET', 'https://map-geocoding.p.rapidapi.com/json', [
                'query' => [
                    'address' => $address,
                ],
                'headers' => [
                    'X-RapidAPI-Host' => 'map-geocoding.p.rapidapi.com',
                    'X-RapidAPI-Key' => $this->apiKey,
                ],
            ]);

            $body = $response->getBody();
            Log::info('Geocoding API response: ' . $body);

            return response()->json(json_decode($body), 200);
        } catch (\Exception $e) {
            Log::error('Geocoding API error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}