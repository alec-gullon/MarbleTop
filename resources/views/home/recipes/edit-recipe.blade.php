@extends('layout.admin')

@section('header')
    <h1>Editing {{ $recipe['name'] }}</h1>
    <p class="heading-tag">Bolognese, Pie, Curry, Cake</p>
@endsection

@section('admin_content')
    <recipe-editor :_items="{{{ json_encode($items) }}}"
                   :_name="'{{ $recipe['name'] }}'"
                   :_recipe="{{{ json_encode($recipe['recipe']) }}}"
                   :_description="{{{ json_encode($recipe['description']) }}}"
                   :_cook-time="{{ $recipe['cook_time'] }}"
                   :_serving-size="{{ $recipe['serving_size'] }}"
                   :_published="{{ $recipe['published'] }}"
                   :_image-id="{{ $recipe['image_id'] }}"
                   :recipe-id="{{ $recipe['id'] }}"
    ></recipe-editor>
@endsection
