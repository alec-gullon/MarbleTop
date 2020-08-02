@extends('layout.app')

@section('content')
    <div class="AdminSection">
        <h1>Add Meal</h1>

        <meal-creator :initial-ingredients-data="{{{ json_encode($ingredientsData) }}}"></meal-creator>
    </div>
@endsection
