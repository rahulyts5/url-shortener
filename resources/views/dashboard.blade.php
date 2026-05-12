@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mt-3 d-flex justify-content-end gap-2">
    @if(auth()->user()->hasRole('superadmin', 'admin'))
        <a href="/invitations/create" class="btn btn-success">Invite User</a>
    @endif

    @if(auth()->user()->hasRole('admin', 'member'))
        <a href="/urls/create" class="btn btn-primary">Create Short URL</a>
    @endif

    @if(auth()->user()->hasRole('admin','superadmin'))
        <a href="/urls" class="btn btn-outline-primary">View URLs</a>
    @else
        <a href="/urls" class="btn btn-outline-primary">My URLs</a>
    @endif
</div>
<div class="card shadow-sm mt-3">
    <div class="card-body">
        <h5>Welcome, {{ auth()->user()->name }}</h5>
        <p class="text-muted">
            Role: <strong>{{ auth()->user()->role }}</strong>
            @if(!auth()->user()->hasRole('superadmin'))&nbsp;|&nbsp;Company: <strong>{{ auth()->user()->company->name ?? 'N/A' }}</strong>
            @endif
        </p>
    </div>
</div>


@endsection
