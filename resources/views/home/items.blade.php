@extends('layout.app')

@section('content')

    <div class="AdminContent">

        <div class="header">
            <h1>Items</h1>
            <p class="heading-tag">Cupboard, fridge, freezer, counter</p>
        </div>

        <items-admin    :init-items="{{{ json_encode($itemsData) }}}"
                        :init-locations="{{{ json_encode($locations) }}}"
        ></items-admin>

    </div>
@endsection
