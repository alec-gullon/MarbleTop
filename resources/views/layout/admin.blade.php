@extends('layout.app')

@section('content')

    <div class="AdminContent">

        <div class="header @if (isset($withIcon)) with-icon @endif">
            @yield('header')
        </div>

        <div class="content">

            <div class="sidebar">
                <ul class="OptionList">
                    <li>
                        <a href="{{ route('plans') }}" class="is-light">
                            @icon('shopping-cart')
                            <span class="text">Plans</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('items') }}" class="is-light is-selected">
                            @icon('home')
                            <span class="text">Items</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('recipes') }}" class="is-light">
                            @icon('heart')
                            <span class="text">Recipes</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('collections') }}" class="is-light">
                            @icon('edit-pencil')
                            <span class="text">Collections</span>
                        </a>
                    </li>
                </ul>
            </div>

            @if (Session::has('message'))
                <div class="MessageBox is-success">
                    {{ Session::get('message') }}
                </div>
            @endif

            @yield('admin_content')
        </div>

    </div>

@endsection
