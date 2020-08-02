@extends('layout.app')

@section('content')
    <div class="AdminSection">
        <h1>Editing {{ $group['name'] }}</h1>

        <group-editor :initial-ingredients-data="{{{ json_encode($ingredientsData) }}}"
                     :initial-name="'{{ $group['name'] }}'"
                     :group-id="{{ $group['id'] }}"
        ></group-editor>
    </div>
@endsection
