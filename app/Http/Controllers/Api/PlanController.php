<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Illuminate\Routing\Controller as BaseController;

use App\Models\Plan;

class PlanController extends BaseController
{
    public function add(Request $request)
    {
        $plan = Plan::create([
            'user_id' => auth()->user()->id
        ]);

        $ingredients = [
            ['id' => 1, 'amount' => 2],
            ['id' => 3, 'amount' => 0.5]
        ];

        foreach ($ingredients as $ingredient) {
            $plan->ingredients()->attach($ingredient['id'], ['amount' => $ingredient['amount']]);
        }
    }
}
