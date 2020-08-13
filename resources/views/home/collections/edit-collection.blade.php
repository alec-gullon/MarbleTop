@extends('layout.admin')

@section('header')
    <h1>Editing {{ $collection['name'] }}</h1>
    <p class="heading-tag">Picnic, family visit, BBQ</p>
@endsection

@section('admin_content')
    <collection-editor :initial-items="{{{ json_encode($itemsData) }}}"
                       :initial-name="'{{ $collection['name'] }}'"
                       :collection-id="{{ $collection['id'] }}"
    ></collection-editor>
@endsection
