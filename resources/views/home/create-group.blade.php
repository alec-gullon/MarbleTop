@extends('layout.app')

@section('content')
    <div class="AdminSection">
        <h1>Add Group</h1>

        <group-creator :initial-ingredients-data="{{{ json_encode($ingredientsData) }}}"></group-creator>
    </div>
@endsection
