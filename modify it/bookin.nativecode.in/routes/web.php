use App\Http\Controllers\ClaimController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\BusinessSearchController;

// ...existing code...

Route::get('/claim-business', [ClaimController::class, 'showClaimForm']);
Route::get('/fetch-leads', [LeadController::class, 'fetchLeads']);
Route::get('/fetch-business', [BusinessController::class, 'fetchBusiness']);
Route::get('/search', [BusinessSearchController::class, 'index'])->name('business.search');
Route::post('/search', [BusinessSearchController::class, 'search'])->name('business.search.submit');
Route::get('/claim/{id}', [ClaimController::class, 'showForm'])->name('business.claim');
Route::post('/claim/{id}', [ClaimController::class, 'claim'])->name('business.claim.submit');
