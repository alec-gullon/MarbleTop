@extends('layout.admin')

@section('header')
    <h1>Editing {{ $recipe['name'] }}</h1>
    <p class="heading-tag">Bolognese, Pie, Curry, Cake</p>
@endsection

@section('admin_content')
    <recipe-editor :initial-items="{{{ json_encode($items) }}}"
                   :initial-name="'{{ $recipe['name'] }}'"
                   :initial-recipe="{{{ json_encode($recipe['recipe']) }}}"
                   :recipe-id="{{ $recipe['id'] }}"
    ></recipe-editor>
@endsection
