@extends('layout.app')

@section('content')
    <div class="AdminContent">

        <div class="header">
            <h1>Meals</h1>
            <p class="heading-tag">Bolognese, Pie, Curry, Cake</p>
        </div>

        <div class="content">
            <meal-creator :initial-items="{{{ json_encode($itemsData) }}}"></meal-creator>
        </div>

    </div>
@endsection
