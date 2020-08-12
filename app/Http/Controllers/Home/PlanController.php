<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Plan;

class PlanController extends Controller
{
    public function index()
    {
        $plans = \App\Helper::plansData(auth()->user());

        return view('home.plans.index', compact('plans'));
    }

    public function add()
    {
        return view('home.plans.create-plan');
    }

    public function show(Plan $plan)
    {
        return view('home.plans.plan', compact('plan'));
    }
}
