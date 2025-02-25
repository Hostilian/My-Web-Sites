@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Search Business</h2>
        </div>
        <div class="card-body">
            <form id="searchForm" action="{{ route('business.search.submit') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Enter Website URL or Search Term</label>
                    <input type="text" name="query" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Search</button>
            </form>

            <div id="progressIndicator" class="mt-4 d-none">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"></div>
                </div>
                <p class="text-center mt-2">Searching...</p>
            </div>

            <div id="results" class="mt-4"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('searchForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.target;
    const progress = document.getElementById('progressIndicator');
    const results = document.getElementById('results');
    
    progress.classList.remove('d-none');
    results.innerHTML = '';

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form)
        });
        const data = await response.json();
        
        if (data.business) {
            results.innerHTML = `
                <div class="business-info">
                    <img src="${data.business.logo || data.business.favicon}" class="business-logo">
                    <h3>${data.business.name}</h3>
                    <p>${data.business.description}</p>
                    <p>Address: ${data.business.address}</p>
                    <p>Categories: ${data.business.categories.join(', ')}</p>
                    <p>Leads: ${data.leads} potential customers</p>
                    <a href="${data.claimUrl}" class="btn btn-success">Claim Business</a>
                </div>
            `;
        } else {
            results.innerHTML = '<div class="alert alert-info">No business found</div>';
        }
    } catch (err) {
        results.innerHTML = '<div class="alert alert-danger">Error searching business</div>';
    }

    progress.classList.add('d-none');
});
</script>
@endpush
@endsection
