@extends('layout.app')

@section('content')
    <div class="AdminContent">

        <div class="header">
            <h1>Recipes</h1>
            <p class="heading-tag">Bolognese, Pie, Curry, Cake</p>
        </div>

        <div class="content">
            <recipe-creator :initial-items="{{{ json_encode($itemsData) }}}"></recipe-creator>
        </div>

    </div>
@endsection
