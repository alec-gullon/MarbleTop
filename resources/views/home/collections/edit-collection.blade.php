@extends('layout.app')

@section('content')
    <div class="AdminContent">
        <div class="header">
            <h1>Editing {{ $collection['name'] }}</h1>
            <p class="heading-tag">Picnic, family visit, BBQ</p>
        </div>

        <div class="content">
            <collection-editor :initial-items="{{{ json_encode($itemsData) }}}"
                          :initial-name="'{{ $collection['name'] }}'"
                          :collection-id="{{ $collection['id'] }}"
            ></collection-editor>
        </div>
    </div>
@endsection
