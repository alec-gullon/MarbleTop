<?php

namespace App\Http\Requests\Api\Meal;

use Illuminate\Foundation\Http\FormRequest;

class StoreMeal extends FormRequest
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
