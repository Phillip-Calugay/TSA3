<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tasks for Today')</title>
    <link rel="stylesheet" href="{{ asset('css/tasks.css') }}">
</head>
<body>
    <header>
        <nav aria-label="Main navigation">
            <a class="brand" href="{{ route('today') }}">Tasks for Today</a>
            <div class="nav-links">
                <a href="{{ route('today') }}" @if(request()->routeIs('today')) aria-current="page" @endif>Today</a>
                <a href="{{ route('tasks.index') }}" @if(request()->routeIs('tasks.index')) aria-current="page" @endif>All Tasks</a>
                <a href="{{ route('profile') }}" @if(request()->routeIs('profile')) aria-current="page" @endif>Profile</a>
                <a href="{{ route('about') }}" @if(request()->routeIs('about')) aria-current="page" @endif>About</a>
            </div>
        </nav>
    </header>
    <main>
        <section class="card">
            @yield('content')
        </section>
    </main>
    <footer>&copy; {{ now()->year }} Tasks for Today</footer>
</body>
</html>
