@extends('layout.app')

@section('content')
    <div class="AdminContent">

        <div class="header">
            <h1>Plans</h1>
            <p class="heading-tag">Let's get ready for a shop</p>
        </div>

        <div class="content">
            @if (Session::has('message'))
                <div class="MessageBox is-success">
                    {{ Session::get('message') }}
                </div>
            @endif

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

            <ul class="OptionList">
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
        </div>

    </div>
@endsection
