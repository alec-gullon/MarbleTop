<?php

namespace App\Http\Requests\Api\Item;

use Illuminate\Foundation\Http\FormRequest;

class DestroyItem extends FormRequest
{
    public function authorize()
    {
        $item = $this->route('item');

        return auth()->user()->is($item->user);
    }

    public function rules()
    {
        return [];
    }
}
