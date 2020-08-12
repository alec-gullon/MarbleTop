<?php

namespace App\Http\Requests\Api\Recipe;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipe extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'recipe' => 'required|string',
            'items' => 'required|JSON'
        ];
    }
}
