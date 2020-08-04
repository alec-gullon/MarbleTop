<?php

namespace App\Http\Requests\Api\Group;

use Illuminate\Foundation\Http\FormRequest;

class DestroyGroup extends FormRequest
{
    public function authorize()
    {
        $group = $this->route('group');
        return auth()->user()->is($group->user);
    }

    public function rules()
    {
        return [];
    }
}
