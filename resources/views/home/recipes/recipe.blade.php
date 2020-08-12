@extends('layout.app')

@section('content')

    <div class="AdminContent">

        <div class="header with-icon">
            <h1>Recipes</h1>
            <a href="/home/recipes/{{ $recipe->id }}/edit/">@icon('edit-pencil')</a>
        </div>

        <div class="content">
            <div class="Recipe">
                <h2 class="heading">
                    Ingredients
                </h2>

                <table class="RecipeIngredients">
                    @foreach ($itemsData as $item)
                        <tr>
                            <td><strong>{{ $item['name'] }}</strong></td>
                            <td>{{ $item['amount'] }}</td>
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
        </div>

    </div>

@endsection
