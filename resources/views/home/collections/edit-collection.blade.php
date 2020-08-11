@extends('layout.app')

@section('content')
    <div class="AdminContent">
        <div class="header">
            <h1>Editing {{ $group['name'] }}</h1>
            <p class="heading-tag">Picnic, family visit, BBQ</p>
        </div>

        <div class="content">
            <group-editor :initial-items="{{{ json_encode($itemsData) }}}"
                          :initial-name="'{{ $group['name'] }}'"
                          :group-id="{{ $group['id'] }}"
            ></group-editor>
        </div>
    </div>
@endsection
