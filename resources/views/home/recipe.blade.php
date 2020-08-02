@extends('layout.app')

@section('content')
    <div class="AdminSection">
        <h1>
            <span>{{ $meal->name }}</span>
            <a href="/home/meals/{{ $meal->id }}/edit/">@icon('edit-pencil')</a>
        </h1>

        <recipe :recipe="{{ json_encode($meal->recipe) }}" :ingredients="{{{ json_encode($ingredientsData) }}}"></recipe>
    </div>
@endsection
