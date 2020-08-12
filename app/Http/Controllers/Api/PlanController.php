<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller as BaseController;

use App\Models\Plan;

class PlanController extends BaseController
{
    public function store(Request $request)
    {
        $plan = Plan::create([
            'user_id' => auth()->user()->id
        ]);

        $items = json_decode($request->items, true);

        foreach ($items as $item) {
            $plan->items()->attach($item['id'], ['amount' => $item['amount']]);
        }

        $request->session()->flash('message', 'Successfully created plan!');

        return ApiResponse::success();
    }
}
