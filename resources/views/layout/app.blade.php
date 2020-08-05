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

        <primary-nav :authenticated="{{ Auth::check() ? 'true' : 'false' }}"
                     :csrftoken="'{{ csrf_token() }}'"
        ></primary-nav>

        @yield('content')

        <div class="Footer">
            Created by Alec Gullon
        </div>

    </div>

    <script>
        document.global = {};
        document.global.apiToken = '{{ Auth::check() ? Auth::user()->api_token : '' }}'
        document.global.xhrActive = false;
    </script>
    <script src="/js/app.js"></script>
</body>
</html>
