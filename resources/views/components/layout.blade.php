<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Russell James F. Bello">

        @php
            $title = "Vehicle PMS Tracking App " . (isset($title) ? " | $title" :  "");
            $current_url = url()->current();
        @endphp

        <title>{{ $title }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="stylesheet" type="text/css" href="/semantic/dist/semantic.min.css">
        <script src="/semantic/dist/semantic.min.js" defer></script>

        @stack('scripts')
    </head>

    <body>
        <div class="ui left mini vertical inverted labeled icon sidebar menu">
            @auth
                <a class="item {{ $current_url == route('home') ? 'active' : '' }}" href="{{ route('home') }}">
                    <i class="home icon"></i>
                    Home
                </a>

                <a class="item {{ $current_url == route('vehicles') ? 'active' : '' }}" href="{{ route('vehicles') }}">
                    <i class="car icon"></i>
                    Vehicles
                </a>

                @can('create', App\Models\Vehicle::class)
                <a class="item {{ $current_url == route('new_vehicle') ? 'active' : '' }}" href="{{ route('new_vehicle') }}">
                    <i class="plus icon"></i>
                    Add Vehicle
                @endcan</a>
            @endauth
        </div>

        <div class="pusher">
            <div class="ui container">
                <div class="ui large attached menu">
                    @auth
                        <div class="item">
                            <x-actions.button id="menu-button" class="basic icon" title="Toggle Menu">
                                <i class="list ul icon"></i>
                            </x-actions.button>
                        </div>
                    @endauth

                    <div id="content-header" class="item">
                        <h3 class="ui header">
                            <i class="icons">
                                <i class="car side icon"></i>
                                <i class="top right corner wrench icon"></i>
                            </i>
                            <div class="content">
                                {{ $title }}
                            </div>
                        </h3>
                    </div>

                    @auth
                        <div class="right menu">
                            <div class="item">
                                <x-actions.button id="menu-button" class="basic icon" title="Log Out" onclick="event.preventDefault(); document.getElementById('logout_form').submit();">
                                    <i class="sign out icon"></i>
                                </x-actions.button>
                            </div>
            
                            <form id="logout_form" action="{{ url('/logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    @endauth
                </div>

                <div id="content" class="ui padded attached segment">
                    <div class="ui grid container">
                        {{ $slot }}
                    </div>
                </div>

                <div class="ui bottom attached mini borderless menu">
                    <div class="item">
                        <i class="copyright outline icon"></i>
                        {{ date('Y', strtotime('now')) }}. All rights reserved.
                    </div>

                    <div class="right menu">
                        <div class="item" data-tooltip="Proudly developed by R. J. Bello." data-variation="mini">
                            <i class="code icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>