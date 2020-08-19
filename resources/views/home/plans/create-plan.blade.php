@extends('layout.admin')

@section('header')
    <h1>Plans</h1>
    <p class="heading-tag">Let's get ready for a shop</p>
@endsection

@section('admin_content')
    <plan-creator :recipes="{{{ json_encode($recipes) }}}"
                  :initial-items="{{ json_encode($items) }}"
                  :locations="{{ json_encode($locations) }}"
    ></plan-creator>
@endsection

@section('test')
    <test data-recipe-count="{{ count($recipes) }}"></test>
@endsection
