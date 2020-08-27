@extends('layout.admin')

@section('header')
    <h1>Hi {{ Auth::user()->name }}!</h1>
    <p class="heading-tag">Today is {{ date('l jS F') }}</p>
@endsection

@section('admin_content')

    <!-- @todo -->
    <div class="HomePublishedRecipes">
        <h2 class="AdminHeading">
            Your published recipes
        </h2>

        <ul>
            @foreach (Auth::user()->publishedRecipes() as $recipe)
                <li>
                    <a href="{{ route('recipe-edit', ['recipe' => $recipe]) }}">
                        <img src="{{ $recipe->imagePath() }}" />
                        <p>{{ $recipe->name }}</p>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <ul class="OptionList hide-for-md">
        <li>
            <a href="{{ route('plans') }}">
                @icon('shopping-cart')
                <span class="text">Plans</span>
            </a>
        </li>
        <li>
            <a href="{{ route('items') }}">
                @icon('home')
                <span class="text">Items</span>
            </a>
        </li>
        <li>
            <a href="{{ route('recipes') }}">
                @icon('heart')
                <span class="text">Recipes</span>
            </a>
        </li>
        <li>
            <a href="{{ route('collections') }}">
                @icon('edit-pencil')
                <span class="text">Collections</span>
            </a>
        </li>
    </ul>

@endsection
