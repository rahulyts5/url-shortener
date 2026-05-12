@extends('layouts.app')

@section('title', 'Short URLs')

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="mb-3">
    <a href="/dashboard" class="btn btn-outline-secondary btn-sm">&larr; Back to Dashboard</a>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Short URLs</h4>
    @if(auth()->user()->hasRole('admin', 'member'))
        <a href="/urls/create" class="btn btn-primary">Create Short URL</a>
    @endif
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Original URL</th>
                    <th>Short URL</th>
                    <th>Clicks</th>
                    <th>Created By</th>
                    <th>Company</th>
                </tr>
            </thead>
            <tbody>
                @forelse($urls as $url)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $url->original_url }}</td>
                    <td>
                        <a href="{{ url('/r/' . $url->short_code) }}" target="_blank">
                            {{ url('/r/' . $url->short_code) }}
                        </a>
                    </td>
                    <td>{{ $url->click_count }}</td>
                    <td>{{ $url->user->name }}</td>
                    <td>{{ $url->company->name ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No URLs found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
