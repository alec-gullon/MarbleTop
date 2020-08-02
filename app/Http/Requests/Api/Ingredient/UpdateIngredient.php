<?php

namespace App\Http\Requests\Api\Ingredient;

use App\Models\Ingredient;
use App\Models\IngredientLocation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateIngredient extends FormRequest
{
    public function authorize()
    {
        $user = auth()->user();
        $ingredient = Ingredient::find($this->ingredientId);

        // technically not an unauthorised request, but will break with the correct status code at rules()
        if ($ingredient === null) {
            return true;
        }
        return ($ingredient->user_id == $user->id);
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'locationId' => 'exists:ingredient_locations,id',
            'ingredientId' => 'exists:ingredients,id'
        ];
    }
}
