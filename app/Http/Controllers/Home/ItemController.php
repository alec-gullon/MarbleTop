<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    public function index()
    {
        $locations = \App\Helper::locationsData();
        $itemsData = \App\Helper::itemsData(auth()->user());

        return view('home.items.index', compact('locations', 'itemsData'));
    }
}
