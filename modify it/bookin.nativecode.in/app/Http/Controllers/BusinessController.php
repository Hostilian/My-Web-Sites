namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BusinessController extends Controller
{
    public function fetchBusiness(Request $request)
    {
        $url = $request->input('url');
        $apiKey = env('GOOGLE_PLACES_API_KEY');
        $placeId = $this->getPlaceId($url, $apiKey);

        if ($placeId) {
            $businessData = $this->getPlaceDetails($placeId, $apiKey);
            return response()->json($businessData);
        }

        return response()->json(['error' => 'Business not found'], 404);
    }

    private function getPlaceId($url, $apiKey)
    {
        $response = Http::get("https://maps.googleapis.com/maps/api/place/findplacefromtext/json", [
            'input' => $url,
            'inputtype' => 'url',
            'fields' => 'place_id',
            'key' => $apiKey,
        ]);

        $data = $response->json();
        return $data['candidates'][0]['place_id'] ?? null;
    }

    private function getPlaceDetails($placeId, $apiKey)
    {
        $response = Http::get("https://maps.googleapis.com/maps/api/place/details/json", [
            'place_id' => $placeId,
            'fields' => 'name,icon,photos,formatted_address,editorial_summary,types,rating,user_ratings_total',
            'key' => $apiKey,
        ]);

        return $response->json()['result'] ?? [];
    }
}
