@extends('layout.app')

@section('content')
    <div class="AdminContent">

        <div class="header">
            <h1>Plans</h1>
            <p class="heading-tag">Let's get ready for a shop</p>
        </div>

        <div class="content">
            <?php
            $recipes = Auth::user()->recipes;

            $recipesData = [];

            $recipeIngredients = [];
            foreach ($recipes as $recipe) {
                $recipeData = [
                    'id' => $recipe->id,
                    'name' => $recipe->name
                ];

                $itemsData = [];
                foreach ($recipe->items as $item) {
                    $itemsData[$item->id] = [
                        'amount' => (int) $item->pivot->amount,
                        'id' => $item->id
                    ];
                }

                $recipeData['items'] = $itemsData;
                $recipesData[$recipe->id] = $recipeData;
            }

            $items = Auth::user()->items;

            $itemsData = [];
            foreach ($items as $item) {
                $itemData = [
                    'name' => $item->name,
                    'locationId' => $item->location_id
                ];

                $itemsData[$item->id] = $itemData;
            }

            $locations = \App\Helper::locationsData();
            ?>

            <plan-creator :recipes="{{{ json_encode($recipesData) }}}"
                          :initial-items="{{ json_encode($itemsData) }}"
                          :locations="{{ json_encode($locations) }}"
            ></plan-creator>
        </div>

    </div>
@endsection
