@extends('layout.app')

@section('content')
    <div class="AdminSection">
        <h1>Plans</h1>

        <div class="MealsAdmin">
            @if (Session::has('message'))
                <div class="MessageBox is-success">
                    {{ Session::get('message') }}
                </div>
            @endif

            <a class="AdminLink" href="/home/plans/create/">
                Create a plan
            </a>

            <div class="meals">
                @foreach ($plans as $plan)
                    <li>{{ $plan['created_at'] }}</li>
                @endforeach
            </div>
        </div>
    </div>
@endsection
