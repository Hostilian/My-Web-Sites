<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GooglePlacesService;
use App\Services\MetaTagService;
use App\Services\LeadService;

class BusinessSearchController extends Controller
{
    protected $placesService;
    protected $metaService;
    protected $leadService;

    public function __construct(
        GooglePlacesService $placesService,
        MetaTagService $metaService,
        LeadService $leadService
    ) {
        $this->placesService = $placesService;
        $this->metaService = $metaService;
        $this->leadService = $leadService;
    }

    public function index()
    {
        return view('business.search');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        // First try to get meta tags
        $metaData = $this->metaService->getMetaTags($query);
        
        // Then try Google Places
        $placeData = $this->placesService->findBusiness($query);
        
        // Get leads count
        $keywords = $placeData['types'] ?? $metaData['keywords'] ?? [];
        $leadsCount = $this->leadService->getLeadsCount($keywords);

        return response()->json([
            'business' => [
                'name' => $placeData['name'] ?? $metaData['title'],
                'description' => $placeData['editorial_summary'] ?? $metaData['description'],
                'logo' => $placeData['icon'] ?? "https://www.google.com/s2/favicons?domain={$query}",
                'address' => $placeData['formatted_address'] ?? null,
                'categories' => $placeData['types'] ?? [],
                'photos' => $placeData['photos'] ?? [],
                'reviews' => $placeData['reviews'] ?? [],
            ],
            'leads' => $leadsCount,
            'claimUrl' => route('business.claim', ['id' => 1]) // Replace with actual business ID
        ]);
    }
}
