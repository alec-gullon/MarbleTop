@extends('layout.admin')

@section('header')
    <h1>Hi {{ Auth::user()->name }}!</h1>
    <p class="heading-tag">Today is {{ date('l jS F') }}</p>
@endsection

@section('admin_content')

    <div style="padding: 24px">
        Something better will be coming here soon!
    </div>

@endsection
