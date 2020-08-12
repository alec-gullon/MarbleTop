@extends('layout.app')

@section('content')

    <div class="AdminContent">

        <div class="header">
            <h1>Recipes</h1>
            <p class="heading-tag">Bolognese, Pie, Curry, Cake</p>
        </div>

        <div class="content">
            @if (Session::has('message'))
                <div class="MessageBox is-success">
                    {{ Session::get('message') }}
                </div>
            @endif

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
                @foreach ($recipes as $recipe)
                    <li>
                        <a href="{{ route('recipe-details', ['recipe' => $recipe['id']]) }}">
                            @icon('arrow-thin-right')
                            <div class="text">
                                {{ $recipe['name'] }}
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>
@endsection
