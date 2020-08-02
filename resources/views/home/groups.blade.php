@extends('layout.app')

@section('content')
    <div class="AdminSection">
        <h1>Groups</h1>

        <div class="MealsAdmin">
            @if (Session::has('message'))
                <div class="MessageBox is-success">
                    {{ Session::get('message') }}
                </div>
            @endif

            <a class="AdminLink" href="/home/groups/create/">
                Add a group
            </a>

            <div class="meals">
                @foreach ($groups as $group)
                    <a class="AdminLink is-edit" href="/home/groups/{{ $group['id'] }}/">{{ $group['name'] }}</a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
