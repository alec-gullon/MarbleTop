@extends('layout.app')

@section('content')

    <div class="AdminContent">

        <div class="header">
            <h1>Meals</h1>
            <p class="heading-tag">Bolognese, Pie, Curry, Cake</p>
        </div>

        <div class="content-with-no-right-gutter">
            @if (Session::has('message'))
                <div class="MessageBox is-success">
                    {{ Session::get('message') }}
                </div>
            @endif

            <ul class="AdminLinkSet">
                <li>
                    <a href="{{ route('meals-add') }}">
                        @icon('plus-outline')
                        <div class="text">
                            Add a Meal
                        </div>
                    </a>
                </li>
            </ul>

                <ul class="AdminLinkSet">
                    @foreach ($meals as $meal)
                        <li>
                            <a href="{{ route('meal-details', ['group' => $meal['id']]) }}">
                                @icon('arrow-thin-right')
                                <div class="text">
                                    {{ $meal['name'] }}
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
        </div>

    </div>
@endsection
