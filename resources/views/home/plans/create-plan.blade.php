@extends('layout.admin')

@section('header')
    <h1>Plans</h1>
    <p class="heading-tag">Let's get ready for a shop</p>
@endsection

@section('admin_content')
    <?php
        $recipes = Auth::user()->recipes;

        $collectionsData = [];

        foreach ($recipes as $recipe) {
            $collectionData = [
                'id' => 'recipe' . $recipe->id,
                'name' => $recipe->name
            ];

            $itemsData = [];
            foreach ($recipe->items as $item) {
                $itemsData[$item->id] = [
                    'amount' => (float) $item->pivot->amount,
                    'id' => $item->id
                ];
            }

            $collectionData['items'] = $itemsData;
            $collectionsData['recipe-' . $recipe->id] = $collectionData;
        }

        $collectionModels = Auth::user()->collections;

        foreach ($collectionModels as $collection) {
            $collectionData = [
                'id' => 'collection-' . $collection->id,
                'name' => $collection->name,
            ];

            $itemsData = [];
            foreach ($collection->items as $item) {
                $itemsData[$item->id] = [
                    'amount' => (float) $item->pivot->amount,
                    'id' => $item->id
                ];
            }

            $collectionData['items'] = $itemsData;
            $collectionsData['collection-' . $collection->id] = $collectionData;
        }

        usort($collectionsData, function($a, $b) {
            return $b['name'] < $a['name'];
        });


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

    <plan-creator :recipes="{{{ json_encode($collectionsData) }}}"
                  :initial-items="{{ json_encode($itemsData) }}"
                  :locations="{{ json_encode($locations) }}"
    ></plan-creator>
@endsection
