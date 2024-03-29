<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Models\Plan;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class PlanController extends BaseController
{
    /**
     * Creates and stores a new Plan model
     *
     * @param   Request     $request
     * @return  string
     */
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
