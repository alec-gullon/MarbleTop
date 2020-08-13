@extends('layout.admin')

@section('header')
    <h1>Hi {{ Auth::user()->name }}!</h1>
    <p class="heading-tag">Today is {{ date('l jS F') }}</p>
@endsection

@section('admin_content')
    <ul class="OptionList">
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
            <a href="{{ route('recipes') }}">
                @icon('heart')
                <span class="text">Recipes</span>
            </a>
        </li>
        <li>
            <a href="{{ route('collections') }}">
                @icon('edit-pencil')
                <span class="text">Collections</span>
            </a>
        </li>
    </ul>
@endsection
