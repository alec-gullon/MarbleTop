@extends('layout.app')

@section('content')

    <div class="PageContent">

        <div class="hero">
            <div class="content">
                <h1>Our Recipes</h1>
                <p class="heading-tag is-copy">Whether you’re looking for big Sunday lunch menu inspiration, or need to find some healthy ideas for
                    storecupboard ingredients (take a look at the recipes you can make with one tin of tomatoes!) - fear not.
                    We’ll have a carefully written recipe to suit you. They’ve all been tested by the expert food team at
                    MarbleTop so we know they’ll work first time for you.</p>
            </div>
            <img src="/images/heroes/chopping-board.png" />
        </div>

        <div class="content">
            <div class="RecipeIndex">

                <h2>Today's Featured Recipe</h2>

                <div class="DisplayRecipe">
                    <a href="#">
                        <img src="{{ $featuredRecipe->imagePath() }}" />
                    </a>
                    <div class="body">
                        <div class="heading">
                            <a class="text" href="/recipes/{{ $featuredRecipe->slug }}">
                                <h3 class="text">{{ $featuredRecipe->name }}</h3>
                            </a>
                            <button class="Button is-secondary">
                                Subscribe
                            </button>
                        </div>

                        @include ('components.recipe-details', ['recipe' => $featuredRecipe])
                    </div>
                </div>

                <h2>Recipes We Think You'll Love</h2>

                <div class="PublishedRecipes">

                    @foreach (App\Models\Recipe::where('published', true)->get()->sortByDesc('rating') as $recipe)
                        <div class="recipe">
                            <img src="{{ $recipe->imagePath() }}" />
                            <div class="main">
                                <a href="/recipes/{{ $recipe->slug }}">{{ $recipe->name }}</a>
                                <p>Published by {{ $recipe->user->name }}</p>
                                <ul class="BulletList small-icons">
                                    <li>
                                        @icon('time')
                                        {{ $recipe->cook_time }} mins
                                    </li>
                                    <li>
                                        @icon('food')
                                        Serves {{ $recipe->serving_size }}
                                    </li>
                                </ul>
                            </div>
                            <div class="rating">
                                {{ $recipe->rating }}<span class="out-of">/5</span>
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>
        </div>
    </div>


@endsection
