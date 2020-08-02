@extends('layout.app')

@section('content')

    <div class="Stripes">
        <div class="stripe-one"></div>
        <div class="stripe-two"></div>
        <div class="stripe-three"></div>
        <div class="stripe-four"></div>
        <div class="stripe-five"></div>
        <div class="stripe-six"></div>
    </div>

    <div class="Hero">

        <h1>Ready to cook something <span class="highlighted">amazing?</span></h1>

        <div class="icons">
            @icon('home')
            @icon('heart')
            @icon('shopping-cart')
        </div>

        <div class="buttons">
            <a href="/login/" class="Button is-primary has-shadow">Sign In</a>
            <a href="/account/create/" class="Button is-secondary has-shadow">Create Account</a>
        </div>

    </div>

    <div class="FeatureBoxes">
        <div class="box">
            @icon('bug')
            <h2>Let's cook something amazing</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aspernatur ea, id illo
                magnam quas? Amet in itaque possimus? Corporis eveniet maiores sequi. Cupiditate facere nemo
                nisi odit perspiciatis tempora!
            </p>
        </div>
        <div class="box">
            @icon('bug')
            <h2>Let's cook something amazing</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aspernatur ea, id illo
                magnam quas? Amet in itaque possimus? Corporis eveniet maiores sequi. Cupiditate facere nemo
                nisi odit perspiciatis tempora!
            </p>
        </div>
        <div class="box">
            @icon('bug')
            <h2>Let's cook something amazing</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aspernatur ea, id illo
                magnam quas? Amet in itaque possimus? Corporis eveniet maiores sequi. Cupiditate facere nemo
                nisi odit perspiciatis tempora!
            </p>
        </div>
    </div>

@endsection

