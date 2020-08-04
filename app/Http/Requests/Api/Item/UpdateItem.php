<?php

namespace App\Http\Requests\Api\Item;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItem extends FormRequest
{
    public function authorize()
    {
        $item = $this->route('item');

        return auth()->user()->is($item->user);
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'location_id' => 'exists:item_locations,id'
        ];
    }
}
