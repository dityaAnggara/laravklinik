<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/v/dt/dt-2.2.0/datatables.min.css" rel="stylesheet">
 
<script src="https://cdn.datatables.net/v/dt/dt-2.2.0/datatables.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Scripts 
    
    -->
</head>
<body>
    <script>
        new DataTable('#example', {
        layout: {
            top1: 'searchPanes'
        }
    });
    </script>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto gap-2">
                            <li>
                                <a href="{{ route('home') }}" wire:navigate class="btn {{ request()->routeIs('home') ? 'btn-primary' : 'btn-outline-primary' }}">
                                    Beranda
                                </a>
                            </li>
                            @if (Auth::user()->role == 'admin')
                                <li>
                                <a href="{{ route('user') }}" wire:navigate class="btn {{ request()->routeIs('user') ? 'btn-primary' : 'btn-outline-primary' }}">
                                    Staff
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('pasien') }}" wire:navigate class="btn {{ request()->routeIs('pasien') ? 'btn-primary' : 'btn-outline-primary' }}">
                                    Pasien
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle btn btn-outline-primary" href="#"  data-bs-toggle="dropdown" aria-expanded="false">
                                  Inventory
                                </a>
                                <ul class="dropdown-menu">
                                  <li><a class="dropdown-item" href="{{ route('obat') }}">Obat</a></li>
                                  
                                </ul>
                              </li>
                            @endif
                            @if (Auth::user()->role == 'dokter' || Auth::user()->role == 'apoteker')
                            <li>
                                <a href="{{ route('checkup') }}" wire:navigate class="btn {{ request()->routeIs('checkup') ? 'btn-primary' : 'btn-outline-primary' }}">
                                    Checkup
                                </a>
                            </li>
                            @endif
                            
                           
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                           
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
