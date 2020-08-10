@extends('layout.app')

@section('content')
    <div class="AdminContent">
        <div class="header">
            <h1>Hi {{ Auth::user()->name }}!</h1>
            <p class="heading-tag">Today is {{ date('l jS F') }}</p>
        </div>
        <div class="content">

            <ul class="AdminLinkSet">
                <li>
                    <a href="{{ route('plans') }}">
                        @icon('shopping-cart')
                        <span class="text">Plans</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('items') }}">
                        @icon('home')
                        <span class="text">Cupboard Items</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('meals') }}">
                        @icon('heart')
                        <span class="text">Meals</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('groups') }}">
                        @icon('edit-pencil')
                        <span class="text">Collections</span>
                    </a>
                </li>
            </ul>

        </div>
    </div>
@endsection
