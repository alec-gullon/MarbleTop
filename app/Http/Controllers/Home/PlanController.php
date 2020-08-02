<?php

namespace App\Http\Controllers\Home;

use Illuminate\Routing\Controller as BaseController;

class PlanController extends BaseController {

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add()
    {
        return view('home.create-plan');
    }

}
