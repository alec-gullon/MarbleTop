@extends('layout.app')

@section('content')

    <div class="AdminContent">

        <div class="header">
            <h1>Items</h1>
            <p class="heading-tag">Cupboard, fridge, freezer, counter</p>
        </div>

        <div class="content">

            <items-admin    :initial-items="{{{ json_encode($itemsData) }}}"
                            :locations="{{{ json_encode($locations) }}}"
            ></items-admin>

        </div>

    </div>
@endsection
