<?php

namespace App\Http\Requests\Api\Meal;

use Illuminate\Foundation\Http\FormRequest;

class DestroyMeal extends FormRequest
{
    public function authorize()
    {
        $meal = $this->route('meal');
        return auth()->user()->is($meal->user);
    }

    public function rules()
    {
        return [];
    }
}
