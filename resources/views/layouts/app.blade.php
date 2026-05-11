<!DOCTYPE html>
<html>
<head>
    <title>@yield('title') - URL Shortener</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary px-4">
    <span class="navbar-brand">URL Shortener</span>
    @auth
    <div class="d-flex align-items-center gap-3">
        <span class="text-white">{{ auth()->user()->name }}</span>
        <span class="badge bg-warning text-dark">{{ auth()->user()->role }}</span>
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="btn btn-sm btn-light">Logout</button>
        </form>
    </div>
    @endauth
</nav>

<div class="container mt-4">
    @yield('content')
</div>

</body>
</html>
