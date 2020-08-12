<?php

namespace App\Http\Requests\Api\Collection;

use Illuminate\Foundation\Http\FormRequest;

class StoreCollection extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'items' => 'required|JSON'
        ];
    }
}
