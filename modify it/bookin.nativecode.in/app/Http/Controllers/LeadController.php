namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LeadController extends Controller
{
    public function fetchLeads(Request $request)
    {
        $keywords = $request->input('keywords');
        $apiKey = env('GOOGLE_CUSTOM_SEARCH_API_KEY');
        $cx = env('GOOGLE_CUSTOM_SEARCH_CX');

        $response = Http::get("https://www.googleapis.com/customsearch/v1", [
            'q' => $keywords,
            'cx' => $cx,
            'key' => $apiKey,
        ]);

        $data = $response->json();
        $leadCount = count($data['items'] ?? []);

        return response()->json(['count' => $leadCount]);
    }
}
