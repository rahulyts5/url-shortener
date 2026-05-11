@extends('layouts.app')

@section('title', 'Create Short URL')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5>Create Short URL</h5>
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="/urls">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Original URL</label>
                        <input type="url" name="original_url"
                               value="{{ old('original_url') }}"
                               class="form-control"
                               placeholder="https://example.com"
                               required>
                    </div>
                    <button type="submit" class="btn btn-primary">Generate Short URL</button>
                    <a href="/urls" class="btn btn-secondary">Cancel</a>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
