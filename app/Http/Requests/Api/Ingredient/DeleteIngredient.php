<?php

namespace App\Http\Requests\Api\Ingredient;

use App\Models\Ingredient;
use Illuminate\Foundation\Http\FormRequest;

class DeleteIngredient extends FormRequest
{
    public function authorize()
    {
        $ingredient = $this->route('ingredient');

        return auth()->user()->is($ingredient->user);
    }

    public function rules()
    {
        return [];
    }
}
