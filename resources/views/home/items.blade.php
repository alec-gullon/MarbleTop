@extends('layout.app')

@section('content')

    <div class="AdminContent">

        <div class="header">
            <h1>Items</h1>
            <p class="heading-tag">Cupboard, fridge, freezer, counter</p>
        </div>

        <ingredients-admin :init-ingredients="{{{ json_encode($itemsData) }}}"
                           :locations="{{{ json_encode($locations) }}}"
        ></ingredients-admin>

    </div>
@endsection
