@extends('layout.app')

@section('content')

    <div class="Hero">

        <div class="background"></div>

        <div class="body">
            <h1>
                Managing your kitchen doesn't have to be a nightmare.
            </h1>

            <p>
                Let's make food shopping easy for a change.
            </p>

            <div class="buttons">
                <a href="{{ route('login') }}" class="Button is-primary has-shadow">Sign In</a>
                <a href="{{ route('create-account') }}" class="Button is-secondary has-shadow">Create Account</a>
            </div>
        </div>

    </div>

    <div class="FeatureBoxes">
        <div class="box">
            @icon('home')
            <h2>Cutting Edge</h2>
            <p>We install Nginx, PHP, MySQL, Postgres, Redis, and all of the other goodies you need on the cloud of your choice. No more out-dated PHP installations.
            </p>
        </div>
        <div class="box">
            @icon('heart')
            <h2>Push to Deploy</h2>
            <p>Deploying code couldn't be any easier. Just push to master on your GitHub, Bitbucket, or custom Git repository. We'll handle it from there.
            </p>
        </div>
        <div class="box">
            @icon('bug')
            <h2>Free SSL Certificates</h2>
            <p>Forge integrates with LetsEncrypt, allowing you to obtain free SSL certificates for your Forge powered applications.
            </p>
        </div>
    </div>

@endsection

