<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

use App\Models\Plan;

use App\Vue\PlanCreator;

class PlanController extends Controller
{
    public function index()
    {
        return view('home.plans.index');
    }

    public function add()
    {
        return view('home.plans.create-plan', [
            'locations' => PlanCreator::locations(),
            'items' => PlanCreator::items(),
            'recipes' => PlanCreator::recipes()
        ]);
    }

    public function show(Plan $plan)
    {
        return view('home.plans.plan', [
            'plan' => $plan
        ]);
    }
}
