@php
$withIcon = true;
@endphp

@extends('layout.admin')

@section('header')
    <h1>{{ $recipe->name }}</h1>
    <a href="/home/recipes/{{ $recipe->id }}/edit/">@icon('edit-pencil')</a>
@endsection

@section('admin_content')
    <div class="Recipe">
        <h2 class="heading">
            Ingredients
        </h2>

        <table class="RecipeIngredients">
            @foreach ($primaryItemsData as $item)
                <tr>
                    <td><strong>{{ $item['name'] }}</strong></td>
                    <td>{{ $item['amount'] }}</td>
                </tr>
            @endforeach

            @foreach ($secondaryItemsData as $item)
                    <tr>
                        <td class="secondary" colspan="2"><strong>{{ $item['name'] }}</strong></td>
                    </tr>
            @endforeach
        </table>

        <h2 class="heading">
            Method
        </h2>

        <div class="RecipeOutline">
            {!! $recipe->displayRecipe() !!}
        </div>
    </div>
@endsection
