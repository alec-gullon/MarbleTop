<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

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
