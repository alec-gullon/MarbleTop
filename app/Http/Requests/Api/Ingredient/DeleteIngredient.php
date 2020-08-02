<?php

namespace App\Http\Requests\Api\Ingredient;

use App\Models\Ingredient;
use Illuminate\Foundation\Http\FormRequest;

class DeleteIngredient extends FormRequest
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
            'ingredientId' => 'exists:ingredients,id'
        ];
    }
}
