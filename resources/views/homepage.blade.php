@extends('layout.app')

@section('content')

    <div class="container">

        <div class="Hero">

            <div class="background"></div>

            <div class="body">
                <h1>
                    Managing your kitchen doesn't have to be a nightmare.
                </h1>

                <p>
                    Let's make shopping easy for a change.
                </p>

                <div class="buttons">
                    @if (Auth::check())
                        <a href="{{ route('home') }}" class="Button is-primary has-shadow">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="Button is-primary has-shadow">Log In</a>
                        <a href="{{ route('create-account') }}" class="Button is-secondary has-shadow">Create Account</a>
                    @endif
                </div>
            </div>

        </div>

        <div class="FeatureBoxes">
            <div class="box">
                @icon('happy-face')
                <h2>Easy to use</h2>
                <p>
                    MarbleTop is expertly crafted to work on all your devices. So whether you're managing your recipes
                    from the office, rummaging through the cupboards looking for what you already have in or at the shops,
                    you'll be able to get yourself sorted with complete ease.
                </p>
            </div>
            <div class="box">
                @icon('cloud')
                <h2>Available Anywhere</h2>
                <p>
                    Everything is stored in the cloud, so you can quickly get the stuff you need anywhere you can find an internet connection.
                </p>
            </div>
            <div class="box">
                @icon('globe')
                <h2>Environmentally Friendly</h2>
                <p>
                    MarbleTop is the most environmentally friendly way to manage your kitchen. Plan ahead and ensure that
                    you get only exactly what you need and nothing more for the week.
                </p>
            </div>

            <div class="box">
                @icon('globe')
                <h2>Environmentally Friendly</h2>
                <p>
                    MarbleTop is the most environmentally friendly way to manage your kitchen. Plan ahead and ensure that
                    you get only exactly what you need and nothing more for the week.
                </p>
            </div>
            <div class="box">
                @icon('happy-face')
                <h2>Easy to use</h2>
                <p>
                    MarbleTop is expertly crafted to work on all your devices. So whether you're managing your recipes
                    from the office, rummaging through the cupboards looking for what you already have in or at the shops,
                    you'll be able to get yourself sorted with complete ease.
                </p>
            </div>
            <div class="box">
                @icon('cloud')
                <h2>Available Everywhere</h2>
                <p>
                    Everything is stored in the cloud, so you can quickly get the stuff you need anywhere you can find an internet connection.
                </p>
            </div>
        </div>

    </div>

@endsection

