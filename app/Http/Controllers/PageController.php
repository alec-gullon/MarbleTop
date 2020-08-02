<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function index()
    {
        return view('homepage');
    }

    public function createAccount()
    {
        return view('account.create');
    }

}
