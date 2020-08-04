<?php

namespace App\Http\Requests\Api\Item;

use Illuminate\Foundation\Http\FormRequest;

class StoreItem extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'location_id' => 'exists:item_locations,id'
        ];
    }
}
