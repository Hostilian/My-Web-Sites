<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GooglePlacesService
{
    protected $apiKey;
    
    public function __construct()
    {
        $this->apiKey = config('services.google.places_api_key');
    }

    public function findBusiness($query)
    {
        // First get Place ID
        $response = Http::get('https://maps.googleapis.com/maps/api/place/findplacefromtext/json', [
            'input' => $query,
            'inputtype' => 'textquery',
            'key' => $this->apiKey
        ]);

        $data = $response->json();
        if (empty($data['candidates'])) {
            return null;
        }

        $placeId = $data['candidates'][0]['place_id'];

        // Then get place details
        $details = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
            'place_id' => $placeId,
            'fields' => 'name,icon,photos,formatted_address,editorial_summary,types,reviews',
            'key' => $this->apiKey
        ]);

        return $details->json()['result'] ?? null;
    }
}
