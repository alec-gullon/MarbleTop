@extends('layout.app')

@section('content')
    <div class="AdminSection">
        <h1>Editing {{ $meal['name'] }}</h1>

        <meal-editor :initial-ingredients-data="{{{ json_encode($ingredientsData) }}}"
                     :initial-name="'{{ $meal['name'] }}'"
                     :initial-recipe="{{{ json_encode($meal['recipe']) }}}"
                     :meal-id="{{ $meal['id'] }}"
        ></meal-editor>
    </div>
@endsection
