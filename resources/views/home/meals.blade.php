@extends('layout.app')

@section('content')
    <div class="AdminSection">
        <h1>Meals</h1>

        <div class="MealsAdmin">
            @if (Session::has('message'))
                <div class="MessageBox is-success">
                    {{ Session::get('message') }}
                </div>
            @endif

            <a class="AdminLink" href="/home/meals/create/">
                Add a meal
            </a>

            <div class="meals">
                @foreach ($meals as $meal)
                    <a class="AdminLink is-edit" href="/home/meals/{{ $meal['id'] }}">{{ $meal['name'] }}</a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
