<?php

namespace App\Http\Requests\Api\Collection;

use Illuminate\Foundation\Http\FormRequest;

class DestroyCollection extends FormRequest
{
    public function authorize()
    {
        $collection = $this->route('collection');
        return auth()->user()->is($collection->user);
    }

    public function rules()
    {
        return [];
    }
}
