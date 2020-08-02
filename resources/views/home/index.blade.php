@extends('layout.app')

@section('content')
    <div class="Home">
        <h1>Hi Alec!</h1>
        <span class="date">Today is Friday 24 Jul</span>

        <div class="heading">
            <h2>Latest Plan</h2>
            <a href="/#">More</a>
        </div>
        <div class="latest-plan" href="#">
            <div class="date">
                <span class="day">23</span>
                <span class="month">July</span>
            </div>
            <a href="#">
                Details
            </a>
        </div>

        <div class="heading">
            <h2>Your Data</h2>
            <a href="/#">More</a>
        </div>

        <a href="/home/ingredients/" class="home-option">
            @icon('home')
            <div class="text">
                <h3>Items</h3>
                <p>Everything that you might need to put on a shopping list</p>
            </div>
        </a>

        <a href="/home/meals/" class="home-option">
            @icon('heart')
            <div class="text">
                <h3>Recipes</h3>
                <p>All the meals you like to make</p>
            </div>
        </a>

        <a href="/home/groups/" class="home-option">
            @icon('edit-pencil')
            <div class="text">
                <h3>Collections</h3>
                <p>Other grouping of households items</p>
            </div>
        </a>

        <a href="/home/plans/" class="home-option">
            @icon('shopping-cart')
            <div class="text">
                <h3>Plans</h3>
                <p>The shopping plans you've made</p>
            </div>
        </a>

    </div>
@endsection
