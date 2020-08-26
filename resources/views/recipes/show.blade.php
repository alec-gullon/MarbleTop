@extends('layout.app')

@section('content')

    <div class="PublicRecipe">

        <ul class="Breadcrumbs">
            <li>
                <a href="/">Home</a>
            </li>
            <li>
                <a href="/recipes">Recipes</a>
            </li>
            <li>
                {{ $recipe->name }}
            </li>
        </ul>

        <div class="DisplayRecipe">
            <img src="{{ $recipe->imagePath() }}" />
            <div class="body">
                <div class="heading">
                    <h1 class="text">{{ $recipe->name }}</h1>
                    <button class="Button is-secondary">
                        Subscribe
                    </button>
                </div>

                @include ('components.recipe-details', ['recipe' => $recipe])

            </div>
        </div>

        <div class="body">
            <div class="ingredients">
                <h2>Ingredients</h2>
                <ul>
                    @foreach ($recipe->items as $ingredient)
                        <li>{{ $ingredient->pivot->precise_amount }} {{ $ingredient->name }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="method">
                <h2>Method</h2>
                <ul>
                    @foreach ($recipe->recipeParts() as $key => $part)
                        <li>
                            <div class="CircledNumber">{{ $key + 1 }}</div>
                            {{ $part }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

@endsection
