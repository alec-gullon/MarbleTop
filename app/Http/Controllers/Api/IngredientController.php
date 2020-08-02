<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;

use App\Models\Ingredient;
use App\Helper;

use App\Http\Requests\Api\Ingredient\AddIngredient;
use App\Http\Requests\Api\Ingredient\UpdateIngredient;
use App\Http\Requests\Api\Ingredient\DeleteIngredient;

class IngredientController extends BaseController
{
    public function add(AddIngredient $request)
    {
        $user = auth()->user();

        $ingredients = $user->ingredients->where('name', $request->name);

        if (count($ingredients) !== 0) {
            $response = [
                'status' => 400,
                'error' => 'ingredientAlreadyExists'
            ];
            return json_encode($response);
        }

        $ingredient = new Ingredient();
        $ingredient->user_id = $user->id;
        $ingredient->name = $request->name;
        $ingredient->location_id = $request->locationId;

        $ingredient->save();

        $response = ['status' => 200];
        if (isset($request->respondWithIngredients)) {
            $response['ingredients'] = Helper::ingredientsData($user);
        }
        return json_encode($response);
    }

    public function update(UpdateIngredient $request)
    {
        $user = auth()->user();

        $ingredient = Ingredient::find($request->ingredientId);
        $ingredients = $user->ingredients->where('name', $request->name);

        if ($ingredient->name !== $request->name && count($ingredients) !== 0) {
            $response = [
                'status' => 400,
                'error' => 'ingredientAlreadyExists'
            ];
            return json_encode($response);
        }

        $ingredient->name = $request->name;
        $ingredient->location_id = $request->locationId;
        $ingredient->save();

        $response = ['status' => 200];
        if (isset($request->respondWithIngredients)) {
            $response['ingredients'] = Helper::ingredientsData($user);
        }
        return json_encode($response);
    }

    public function delete(DeleteIngredient $request)
    {
        $user = auth()->user();

        $ingredient = Ingredient::find($request->ingredientId);

        if ($ingredient->user_id != $user->id) {
            return json_encode(['status' => 400]);
        }

        $ingredient->delete();

        $response = ['status' => 200];
        if (isset($request->respondWithIngredients)) {
            $response['ingredients'] = Helper::ingredientsData($user);
        }
        return json_encode($response);
    }
}
