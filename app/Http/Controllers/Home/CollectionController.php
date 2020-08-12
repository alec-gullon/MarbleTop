<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

use App\Helper;

use App\Models\Collection;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = \App\Helper::collectionsData(auth()->user());

        return view('home.collections.index', compact('collections'));
    }

    public function show()
    {
        $itemsData = Helper::itemsData(auth()->user());
        foreach ($itemsData as $key => $item) {
            $data = $item;

            $data['key'] = $key;
            $data['selected'] = false;
            $data['amount'] = 1;

            $itemsData[$key] = $data;
        }

        return view('home.collections.create-collection', compact('itemsData'));
    }

    public function edit(Collection $collection)
    {
        $itemsData = Helper::itemsData(auth()->user());
        foreach ($itemsData as $key => $item) {
            $data = $item;

            $selected = false;
            $amount = 1;

            foreach ($collection->items as $collectionItem) {
                if ($collectionItem->id === $item['id']) {
                    $selected = true;
                    $amount = (float) $collectionItem->pivot->amount;
                }
            }

            $data['key'] = $key;
            $data['selected'] = $selected;
            $data['amount'] = $amount;

            $itemsData[$key] = $data;
        }

        return view('home.collections.edit-collection', compact('collection', 'itemsData'));
    }
}
