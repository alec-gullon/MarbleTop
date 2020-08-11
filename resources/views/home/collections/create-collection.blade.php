@extends('layout.app')

@section('content')
    <div class="AdminContent">

        <div class="header">
            <h1>Add a Collection</h1>
            <p class="heading-tag">Picnic, family visit, BBQ</p>
        </div>

        <div class="content">
            <group-creator :initial-items="{{{ json_encode($itemsData) }}}"></group-creator>
        </div>

    </div>
@endsection
