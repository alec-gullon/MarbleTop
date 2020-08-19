@extends('layout.app')

@section('content')

    <div class="AdminContent">

        <div class="header-wrapper">
            <div class="header @if (isset($withIcon))with-icon @endif">
                @yield('header')
            </div>
        </div>

        <div class="content-wrapper">
            <div class="content">

                @php
                    $route = Route::current()->getName();

                    $areas = ['plan', 'item', 'recipe', 'collection'];

                    $selectedArea = '';
                    foreach ($areas as $area) {
                        if (strpos($route, $area) === 0) {
                            $selectedArea = $area;
                            break;
                        }
                    }
                @endphp

                <div class="sidebar">
                    <ul class="OptionList">
                        <li>
                            <a href="{{ route('plans') }}"
                               class="is-light {{ $selectedArea === 'plan' ? 'is-selected': '' }}"
                            >
                                @icon('shopping-cart')
                                <span class="text">Plans</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('items') }}"
                               class="is-light {{ $selectedArea === 'item' ? 'is-selected': '' }}"
                            >
                                @icon('home')
                                <span class="text">Items</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('recipes') }}"
                               class="is-light {{ $selectedArea === 'recipe' ? 'is-selected _recipe': '' }}"
                            >
                                @icon('heart')
                                <span class="text">Recipes</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('collections') }}"
                               class="is-light {{ $selectedArea === 'collection' ? 'is-selected': '' }}"
                            >
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

    </div>

@endsection
