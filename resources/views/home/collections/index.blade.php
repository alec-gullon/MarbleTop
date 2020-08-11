@extends('layout.app')

@section('content')

    <div class="AdminContent">

        <div class="header">
            <h1>Collections</h1>
            <p class="heading-tag">Picnic, family visit, BBQ</p>
        </div>

        <div class="content">
            @if (Session::has('message'))
                <div class="MessageBox is-success">
                    {{ Session::get('message') }}
                </div>
            @endif

            <ul class="OptionList">
                <li>
                    <a href="{{ route('collections-add') }}">
                        @icon('plus-outline')
                        <div class="text">
                            Add a Collection
                        </div>
                    </a>
                </li>
            </ul>

            <ul class="OptionList">
                @foreach ($groups as $group)
                    <li>
                        <a href="{{ route('collections-edit', ['group' => $group['id']]) }}">
                            @icon('arrow-thin-right')
                            <div class="text">
                                {{ $group['name'] }}
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>

        </div>

    </div>
@endsection
