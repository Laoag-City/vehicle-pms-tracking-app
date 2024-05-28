<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Russell James F. Bello">

        <title>Vehicle PMS Tracking App {{ isset($title) ? "|$title" :  "" }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="stylesheet" type="text/css" href="/semantic/dist/semantic.min.css">
        <script src="/semantic/dist/semantic.min.js" defer></script>

        @stack('scripts')
    </head>

    <body>
        <div class="ui left vertical inverted labeled icon sidebar menu">
            @auth
                <a class="item">
                    <i class="home icon"></i>
                    Home
                </a>
            @endauth
        </div>

        <div class="pusher">
            <div class="ui container">
                <div class="ui large attached menu">
                    @auth
                        <div class="item">
                            <x-actions.button id="menu-button" class="basic icon">
                                <i class="list ul icon"></i>
                            </x-actions.button>
                        </div>
                    @endauth

                    <div id="content-header" class="item">
                        <h3 class="ui header">{{ $title ?? "" }}</h3>
                    </div>

                    @auth
                        <div class="right menu">
                            <div class="item">
                                <x-actions.button id="menu-button" class="basic icon" onclick="event.preventDefault(); document.getElementById('logout_form').submit();">
                                    <i class="sign out icon"></i>
                                </x-actions.button>
                            </div>
            
                            <form id="logout_form" action="{{ url('/logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    @endauth
                </div>

                <div id="content" class="ui attached segment">
                    <div class="ui centered grid container">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>