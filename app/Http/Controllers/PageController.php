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
        return view('pages.create-account');
    }

    public function about()
    {
        return view('pages.about');
    }
}
