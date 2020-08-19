<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

use App\Vue\ItemsAdmin;

class ItemController extends Controller
{
    public function index()
    {
        return view('home.items.index', [
            'locations' => ItemsAdmin::locations(),
            'items' => ItemsAdmin::items()
        ]);
    }
}
