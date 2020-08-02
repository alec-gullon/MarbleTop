<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Illuminate\Routing\Controller as BaseController;

use App\Models\Meal;

class MealController extends BaseController
{
    public function add(Request $request)
    {
        $request->ingredients = json_decode($request->ingredients);

        $user = auth()->user();

        $meals = $user->meals->where('name', $request->name);
        if (count($meals) !== 0) {
            $response = [
                'status' => 400,
                'error' => 'mealAlreadyExists'
            ];
            return json_encode($response);
        }

        $meal = new Meal();
        $meal->user_id = $user->id;
        $meal->name = $request->name;
        $meal->recipe = $request->recipe;
        $meal->save();

        foreach ($request->ingredients as $ingredient) {
            $meal->ingredients()->attach(
                $ingredient->id,
                [
                    'amount' => $ingredient->amount,
                    'preciseAmount' => $ingredient->preciseAmount,
                    'order' => $ingredient->order
                ]);
        }

        $request->session()->flash('message', 'Successfully added meal!');

        $response = ['status' => 200];
        return json_encode($response);
    }

    public function update(Meal $meal, Request $request)
    {
        $request->ingredients = json_decode($request->ingredients);
        $user = auth()->user();

        if ($meal->name !== $request->name) {
            $meals = $user->meals->where('name', $request->name);
            if (count($meals) !== 0) {
                return json_encode([
                    'status' => 400,
                    'error' => 'mealAlreadyExists'
                ]);
            }
        }

        $meal->name = $request->name;
        $meal->recipe = $request->recipe;
        $meal->save();

        $meal->ingredients()->detach();

        foreach ($request->ingredients as $ingredient) {
            $meal->ingredients()->attach(
                $ingredient->id,
                [
                    'amount' => $ingredient->amount,
                    'preciseAmount' => $ingredient->preciseAmount,
                    'order' => $ingredient->order
                ]);
        }

        $request->session()->flash('message', 'Successfully updated meal!');

        $response = ['status' => 200];
        return json_encode($response);
    }

    public function delete(Meal $meal, Request $request)
    {
        $meal->ingredients()->detach();
        $meal->delete();

        $request->session()->flash('message', 'Successfully deleted meal!');
        return json_encode(['status' => 200]);
    }
}
