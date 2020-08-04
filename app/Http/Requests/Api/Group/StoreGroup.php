<?php

namespace App\Http\Requests\Api\Group;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroup extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'items' => 'required|JSON'
        ];
    }
}
