@extends('layout.admin')

@section('header')
    <h1>Items</h1>
    <p class="heading-tag">Cupboard, fridge, freezer, counter</p>
@endsection

@section('admin_content')
    <div class="content">

        <items-admin    :_items="{{{ json_encode($items) }}}"
                        :_locations="{{{ json_encode($locations) }}}"
        ></items-admin>

    </div>
@endsection
