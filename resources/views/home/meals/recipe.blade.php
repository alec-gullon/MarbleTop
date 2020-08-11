@extends('layout.app')

@section('content')

    <div class="AdminContent">

        <div class="header with-icon">
            <h1>Meals</h1>
            <a href="/home/meals/{{ $meal->id }}/edit/">@icon('edit-pencil')</a>
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
                    {!! $meal->displayRecipe() !!}
                </div>
            </div>
        </div>

    </div>

@endsection
