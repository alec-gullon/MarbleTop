@extends('layout.admin')

@section('header')
    <h1>Create a Recipe</h1>
    <p class="heading-tag">Bolognese, Pie, Curry, Cake</p>
@endsection

@section('admin_content')
    <recipe-creator :initial-items="{{{ json_encode($itemsData) }}}"
    ></recipe-creator>
@endsection
