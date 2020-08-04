<?php

namespace App\Http\Requests\Api\Ingredient;

use Illuminate\Foundation\Http\FormRequest;

class StoreIngredient extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'location_id' => 'exists:ingredient_locations,id'
        ];
    }
}
