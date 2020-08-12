@extends('layout.app')

@section('content')
    <div class="AdminContent">
        <div class="header">
            <h1>Editing {{ $recipe['name'] }}</h1>
            <p class="heading-tag">Bolognese, Pie, Curry, Cake</p>
        </div>

        <div class="content">
            <recipe-editor :initial-items="{{{ json_encode($itemsData) }}}"
                         :initial-name="'{{ $recipe['name'] }}'"
                         :initial-recipe="{{{ json_encode($recipe['recipe']) }}}"
                         :recipe-id="{{ $recipe['id'] }}"
            ></recipe-editor>
        </div>
    </div>
@endsection
