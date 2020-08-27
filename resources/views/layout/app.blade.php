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
            <div class="container">
                <div class="links">
                    <div class="link-set">
                        <span>MarbleTop</span>
                        <ul>
                            <li><a href="#">Gift cards</a></li>
                            <li><a href="#">Unidays</a></li>
                            <li><a href="#">Student Beans</a></li>
                            <li><a href="#">Recipes</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Affiliate</a></li>
                        </ul>
                    </div>

                    <div class="link-set">
                        <span>Our Company</span>
                        <ul>
                            <li><a href="#">MarbleTop Group</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Press</a></li>
                        </ul>
                    </div>

                    <div class="link-set">
                        <span>Help</span>
                        <ul>
                            <li><a href="#">Find an answer</a></li>
                            <li><a href="#">FAQs</a></li>
                        </ul>
                    </div>
                </div>
                <div class="contact">
                    <span>Customer Support</span>
                    <a href="#">Help Center & FAQ</a>
                    <a href="#">contact@marbletop.co.uk</a>
                    <a href="#">(646) 881-4259</a>
                </div>
            </div>
        </div>

        <div class="Legal">
            <div class="container">
                <span>© MarbleTop 2020</span>
                <a href="#">Terms and Conditions</a>
                <a href="#">Privacy</a>
                <a href="#">Modern Slavery Statement</a>
            </div>
        </div>

    </div>

    <script>
        document.global = {};
        document.global.apiToken = '{{ Auth::check() ? Auth::user()->api_token : '' }}';
        document.global.xhrActive = false;
    </script>
    <script src="/js/app.js"></script>
</body>
</html>

@if (App::runningUnitTests())
    @yield('test')
@endif
