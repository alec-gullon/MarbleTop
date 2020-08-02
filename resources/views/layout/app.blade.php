<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MarbleTop</title>

    <link rel="stylesheet" href="/css/app.css" />
</head>
<body>
    <div id="app">

        <?php
            $authenticated = 'false';
            if (Auth::check()) {
                $authenticated = 'true';
            }
        ?>

        <primary-nav :authenticated="{{ $authenticated }}"
                     :csrftoken="'{{ csrf_token() }}'"
        ></primary-nav>

        @yield('content')

        <div class="Footer">
            Created by Alec Gullon
        </div>

    </div>

    <script>
        document.global = {};

        @if (Auth::check())
            document.global.apiToken = '{{ Auth::user()->api_token }}';
        @endif

        document.global.xhrActive = false;

    </script>
    <script src="/js/app.js"></script>
</body>
</html>
