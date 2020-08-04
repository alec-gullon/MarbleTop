<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;

use App\Models\Ingredient;
use App\Helper;
use App\Helpers\ApiResponse;

use App\Http\Requests\Api\Ingredient\StoreIngredient;
use App\Http\Requests\Api\Ingredient\UpdateIngredient;
use App\Http\Requests\Api\Ingredient\DestroyIngredient;

class IngredientController extends BaseController
{
    public function store(StoreIngredient $request)
    {
        $user = auth()->user();

        if ($user->hasIngredient($request->name)) {
            return ApiResponse::error(['error' => 'ingredientAlreadyExists']);
        }

        $user->addIngredient(
            $request->only(['name', 'location_id'])
        );

        return ApiResponse::success(['ingredients' => Helper::ingredientsData($user)]);
    }

    public function update(UpdateIngredient $request, Ingredient $ingredient)
    {
        $user = auth()->user();

        if ($ingredient->name !== $request->name && $user->hasIngredient($request->name)) {
            return ApiResponse::error(['error' => 'ingredientAlreadyExists']);
        }

        $ingredient->update(
            $request->only(['name', 'location_id'])
        );

        return ApiResponse::success(['ingredients' => Helper::ingredientsData($user)]);
    }

    public function destroy(DestroyIngredient $request, Ingredient $ingredient)
    {
        $ingredient->delete();

        return ApiResponse::success(['ingredients' => Helper::ingredientsData(auth()->user())]);
    }
}
