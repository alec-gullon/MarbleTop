@extends('layout.admin')

@section('header')
    <h1>Collections</h1>
    <p class="heading-tag">Picnic, family visit, BBQ</p>
@endsection

@section('admin_content')

    <ul class="OptionList">
        <li>
            <a href="{{ route('collections-add') }}">
                @icon('plus-outline')
                <div class="text">
                    Add a Collection
                </div>
            </a>
        </li>
    </ul>

    <ul class="OptionList">
        @foreach (Auth::user()->collections->sortBy('name') as $collection)
            <li>
                <a href="{{ route('collections-edit', ['collection' => $collection->id]) }}">
                    @icon('arrow-thin-right')
                    <div class="text">
                        {{ $collection->name }}
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
@endsection
