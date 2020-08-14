<?php

namespace App\Http\Controllers\Home;

use App\Helper;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    public function index()
    {
        $locations = Helper::locationsData();
        $itemsData = Helper::itemsData(auth()->user());

        foreach ($locations as $key => $location) {
            $locations[$key]['expanded'] = false;
        }

        return view('home.items.index', compact('locations', 'itemsData'));
    }
}
