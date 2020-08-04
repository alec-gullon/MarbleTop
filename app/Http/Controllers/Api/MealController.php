<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Illuminate\Routing\Controller as BaseController;

use App\Models\Meal;

use App\Helpers\ApiResponse;

use App\Http\Requests\Api\Meal\StoreMeal;
use App\Http\Requests\Api\Meal\UpdateMeal;
use App\Http\Requests\Api\Meal\DestroyMeal;

class MealController extends BaseController
{
    public function store(StoreMeal $request)
    {
        $user = auth()->user();
        $request->items = json_decode($request->items, true);

        if ($user->hasMeal($request->name)) {
            return ApiResponse::error(['error' => 'mealAlreadyExists']);
        }

        $meal = $user->addMeal(
            $request->only('name', 'recipe')
        );

        $meal->attachItems($request->items);

        $request->session()->flash('message', 'Successfully added meal!');

        return ApiResponse::success();
    }

    public function update(UpdateMeal $request, Meal $meal)
    {
        $user = auth()->user();
        $request->items = json_decode($request->items, true);

        if ($meal->name !== $request->name && $user->hasMeal($request->name)) {
            return ApiResponse::error(['error' => 'mealAlreadyExists']);
        }

        $meal->update(
            $request->only('name', 'recipe')
        );

        $meal->items()->detach();

        $meal->attachItems($request->items);

        $request->session()->flash('message', 'Successfully updated meal!');

        return ApiResponse::success();
    }

    public function destroy(DestroyMeal $request, Meal $meal)
    {
        $meal->delete();

        $request->session()->flash('message', 'Successfully deleted meal!');
        return ApiResponse::success();
    }
}
