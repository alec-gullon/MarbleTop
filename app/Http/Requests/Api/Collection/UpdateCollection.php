<?php

namespace App\Http\Requests\Api\Collection;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCollection extends FormRequest
{
    public function authorize()
    {
        $collection = $this->route('collection');
        return auth()->user()->is($collection->user);
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'items' => 'required|JSON'
        ];
    }
}
