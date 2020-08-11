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

        return view('home.plans.index', compact('plans'));
    }

    public function add()
    {
        return view('home.plans.create-plan');
    }
}
