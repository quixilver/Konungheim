<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Konungheim') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h1 class="display-4 mb-4">⚔️ Welcome to Konungheim</h1>
                <p class="lead mb-4">A Laravel site for the HWtP (Hardcore-Way-to-Play) for Valheim</p>
                
                <div class="row mb-5">
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">🗡️ Characters</h5>
                                <p class="card-text">Manage your Viking characters with their roles, perks, and objectives.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">🌍 Worlds</h5>
                                <p class="card-text">Track different Valheim worlds with their seeds and traits.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">👥 Roles</h5>
                                <p class="card-text">Define character roles with specific perks and abilities.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">⭐ Perks</h5>
                                <p class="card-text">Manage character perks and special abilities.</p>
                            </div>
                        </div>
                    </div>
                </div>

                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg me-3">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-3">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Register</a>
                @endauth
            </div>
        </div>
    </div>
</body>
</html>