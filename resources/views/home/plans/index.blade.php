@extends('layout.admin')

@section('header')
    <h1>Plans</h1>
    <p class="heading-tag">Let's get ready for a shop</p>
@endsection

@section('admin_content')
    <ul class="OptionList">
        <li>
            <a href="{{ route('plans-add') }}">
                @icon('plus-outline')
                <div class="text">
                    Add a Plan
                </div>
            </a>
        </li>
    </ul>

    <ul class="OptionList" data-test="{{ count(Auth::user()->plans) }}">
        @foreach (Auth::user()->plans as $plan)
            <li>
                <a href="{{ route('plan', ['plan' => $plan->id]) }}">
                    @icon('arrow-thin-right')
                    <div class="text">
                        {{ $plan->created_at->toFormattedDateString() }}
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
@endsection
