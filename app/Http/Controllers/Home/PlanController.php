<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $plans = \App\Helper::plansData(auth()->user());

        return view('home.plans', compact('plans'));
    }

    public function add()
    {
        return view('home.create-plan');
    }
}
