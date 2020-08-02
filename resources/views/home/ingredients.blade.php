@extends('layout.app')

@section('content')

    <div class="AdminSection">

        <h1>Ingredients</h1>

        <ingredients-admin :init-ingredients="{{{ json_encode($ingredientsData) }}}"
                           :locations="{{{ json_encode($locations) }}}"
        ></ingredients-admin>

    </div>
@endsection
