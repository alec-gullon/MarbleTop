@extends('layout.app')

@section('content')
    <div class="AdminContent">

        <div class="header">
            <h1>Viewing Plan</h1>
            <p class="heading-tag">Created on {{ $plan->created_at->toFormattedDateString() }}</p>
        </div>

        <div class="content">
            <div class="Plan">
                @foreach ($plan->itemsByLocation() as $location => $items)
                    <h2>{{ App\Models\ItemLocation::find($location)->name }}</h2>

                    <div class="item-list">
                        @foreach ($items as $item)
                            <div class="item">
                                <div class="name">{{ $item->name }}</div>
                                <div class="amount">{{ $item->pivot->amount }}</div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection
