<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

use App\Models\Collection;

use App\Vue\CollectionCreator;
use App\Vue\CollectionEditor;

class CollectionController extends Controller
{
    public function index()
    {
        return view('home.collections.index');
    }

    public function show()
    {
        return view('home.collections.create-collection', [
            'items' => CollectionCreator::items()
        ]);
    }

    public function edit(Collection $collection)
    {
        return view('home.collections.edit-collection', [
            'collection' => $collection,
            'items' => CollectionEditor::items($collection)
        ]);
    }
}
