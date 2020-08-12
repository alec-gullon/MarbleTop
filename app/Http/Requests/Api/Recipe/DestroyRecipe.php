<?php

namespace App\Http\Requests\Api\Recipe;

use Illuminate\Foundation\Http\FormRequest;

class DestroyRecipe extends FormRequest
{
    public function authorize()
    {
        $recipe = $this->route('recipe');
        return auth()->user()->is($recipe->user);
    }

    public function rules()
    {
        return [];
    }
}
