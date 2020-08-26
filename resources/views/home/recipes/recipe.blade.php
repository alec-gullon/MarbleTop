@php
$withIcon = true;
@endphp

@extends('layout.admin')

@section('header')
    <h1>{{ $recipe->name }}</h1>
    <a href="{{ route('recipe-edit', ['recipe' => $recipe->id]) }}">@icon('edit-pencil')</a>
@endsection

@section('admin_content')
    <div class="Recipe">

        <div class="header">
            <img src="{{ $recipe->imagePath() }}" />

            <div class="RecipeIngredients">
                <h2 class="heading">
                    Ingredients
                </h2>

                <table>
                @foreach ($recipe->primaryItems() as $item)
                    <tr>
                        <td><strong>{{ $item->name }}</strong></td>
                        <td>{{ $item->pivot->precise_amount }}</td>
                    </tr>
                @endforeach

                @foreach ($recipe->secondaryItems() as $item)
                    <tr>
                        <td class="secondary" colspan="2"><strong>{{ $item->name }}</strong></td>
                    </tr>
                @endforeach
                </table>
            </div>
        </div>


        <h2 class="heading">
            Method
        </h2>

        <div class="RecipeOutline">
            {!! $recipe->displayRecipe() !!}
        </div>
    </div>
@endsection
