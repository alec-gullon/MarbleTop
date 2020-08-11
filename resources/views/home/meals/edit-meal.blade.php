@extends('layout.app')

@section('content')
    <div class="AdminContent">
        <div class="header">
            <h1>Editing {{ $meal['name'] }}</h1>
            <p class="heading-tag">Bolognese, Pie, Curry, Cake</p>
        </div>

        <div class="content">
            <meal-editor :initial-items="{{{ json_encode($itemsData) }}}"
                         :initial-name="'{{ $meal['name'] }}'"
                         :initial-recipe="{{{ json_encode($meal['recipe']) }}}"
                         :meal-id="{{ $meal['id'] }}"
            ></meal-editor>
        </div>
    </div>
@endsection
