namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClaimController extends Controller
{
    public function showClaimForm(Request $request)
    {
        $url = $request->input('url');
        $domain = parse_url($url, PHP_URL_HOST);
        return view('claim-business', compact('domain'));
    }
}
