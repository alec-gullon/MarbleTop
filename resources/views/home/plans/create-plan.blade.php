@extends('layout.app')

@section('content')
    <div class="AdminContent">

        <div class="header">
            <h1>Plans</h1>
            <p class="heading-tag">Let's get ready for a shop</p>
        </div>

        <div class="content">
            <?php
            $meals = Auth::user()->meals;

            $mealsData = [];

            $mealIngredients = [];
            foreach ($meals as $meal) {
                $mealData = [
                    'id' => $meal->id,
                    'name' => $meal->name
                ];

                $itemsData = [];
                foreach ($meal->items as $item) {
                    $itemsData[$item->id] = [
                        'amount' => (int) $item->pivot->amount,
                        'id' => $item->id
                    ];
                }

                $mealData['items'] = $itemsData;
                $mealsData[$meal->id] = $mealData;
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

            <plan-creator :meals="{{{ json_encode($mealsData) }}}"
                          :initial-items="{{ json_encode($itemsData) }}"
                          :locations="{{ json_encode($locations) }}"
            ></plan-creator>
        </div>

    </div>
@endsection
