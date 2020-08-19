@extends('layout.admin')

@section('header')
    <h1>Recipes</h1>
    <p class="heading-tag">Bolognese, Pie, Curry, Cake</p>
@endsection

@section('admin_content')

    <ul class="OptionList">
        <li>
            <a href="{{ route('recipes-add') }}">
                @icon('plus-outline')
                <div class="text">
                    Add a Recipe
                </div>
            </a>
        </li>
    </ul>

    <ul class="OptionList">
        @foreach (Auth::user()->recipes as $recipe)
            <li>
                <a href="{{ route('recipe-details', ['recipe' => $recipe->id]) }}">
                    @icon('arrow-thin-right')
                    <div class="text">
                        {{ $recipe->name }}
                    </div>
                </a>
            </li>
        @endforeach
    </ul>

@endsection
