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

                <a href="#" class="item" onclick="event.preventDefault(); document.getElementById('logout_form').submit();">
                    <i class="sign out icon"></i>
                    Log Out
                </a>

                <form id="logout_form" action="{{ url('/logout') }}" method="POST" class="hidden">
                    @csrf
    			</form>
            @endauth
        </div>

        <div class="pusher">
            <div class="ui container">
                <h2 id="content-header" class="ui top attached header">{{ $title ?? "" }}</h2>

                <div id="content" class="ui attached segment">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>