@extends('layout.app')

@section('content')
    <div class="AdminSection">
        <h1>Add Meal</h1>

        <?php
            $meals = Auth::user()->meals;

            $mealsData = [];

            $mealIngredients = [];
            foreach ($meals as $meal) {
                $mealData = [
                    'id' => $meal->id,
                    'name' => $meal->name
                ];

                $ingredientsData = [];
                foreach ($meal->ingredients as $ingredient) {
                    $ingredientsData[$ingredient->id] = [
                        'amount' => (int) $ingredient->pivot->amount,
                        'id' => $ingredient->id
                    ];
                }

                $mealData['ingredients'] = $ingredientsData;
                $mealsData[$meal->id] = $mealData;
            }

            $ingredients = Auth::user()->ingredients;

            $ingredientsData = [];
            foreach ($ingredients as $ingredient) {
                $ingredientData = [
                    'name' => $ingredient->name,
                    'amount' => 0
                ];

                $ingredientsData[$ingredient->id] = $ingredientData;
            }
        ?>

        <plan-creator :meals-data="{{{ json_encode($mealsData) }}}" :ingredients-data="{{ json_encode($ingredientsData) }}"
        ></plan-creator>
    </div>
@endsection
