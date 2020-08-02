<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home.index');
    }

    public function meals()
    {
        $meals = \App\Helper::mealsData(auth()->user());

        return view('home.meals', compact('meals'));
    }

    public function groups()
    {
        $groups = \App\Helper::groupsData(auth()->user());

        return view('home.groups', compact('groups'));
    }

    public function plans()
    {
        $plans = \App\Helper::plansData(auth()->user());

        return view('home.plans', compact('plans'));
    }
}
