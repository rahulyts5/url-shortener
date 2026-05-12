@extends('layouts.app')

@section('title', 'Create Invitation')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5>Invite User</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="/invitations">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="name" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                        @if(auth()->user()->role === 'superadmin')
                                <option value="admin">Admin</option>
                        @elseif(auth()->user()->role === 'admin')
                                <option value="admin">Admin</option>
                                <option value="member">Member</option>
                        @endif
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="company_id" class="form-label">Company</label>
                        <select class="form-select" id="company_id" name="company_id" required>
                            @if(auth()->user()->role === 'superadmin')
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                                <option value="">Other</option>
                            @else
                                <option value="{{ auth()->user()->company_id }}">{{ auth()->user()->company->name }}</option>
                            @endif
                        </select>
                    </div>

                    @if(auth()->user()->role === 'superadmin')
                    <div class="mb-3" id="company_name_field" style="display: none;">
                        <label for="company_name" class="form-label">New Company Name</label>
                        <input type="text" class="form-control" id="company_name" name="company_name">
                    </div>
                    @endif

                    <button type="submit" class="btn btn-primary">Send Invitation</button>
                    <a href="/dashboard" class="btn btn-outline-secondary">&larr; Back</a>
                </form>
            </div>
        </div>
    </div>
</div>

@if(auth()->user()->role === 'superadmin')
<script>
document.getElementById('company_id').addEventListener('change', function() {
    const companyNameField = document.getElementById('company_name_field');
    if (this.value === '') {
        companyNameField.style.display = 'block';
        document.getElementById('company_name').required = true;
    } else {
        companyNameField.style.display = 'none';
        document.getElementById('company_name').required = false;
    }
});
</script>
@endif
@endsection
