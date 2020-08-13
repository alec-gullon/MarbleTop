@extends('layout.admin')

@section('header')
    <h1>Add a Collection</h1>
    <p class="heading-tag">Picnic, family visit, BBQ</p>
@endsection

@section('admin_content')
    <collection-creator :initial-items="{{{ json_encode($itemsData) }}}"></collection-creator>
@endsection
