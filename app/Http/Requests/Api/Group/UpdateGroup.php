<?php

namespace App\Http\Requests\Api\Group;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGroup extends FormRequest
{
    public function authorize()
    {
        $group = $this->route('group');
        return auth()->user()->is($group->user);
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'items' => 'required|JSON'
        ];
    }
}
