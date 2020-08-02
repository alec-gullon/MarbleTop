<?php

namespace App\Http\Controllers\Home;

use Illuminate\Routing\Controller as BaseController;

use App\Helper;

use App\Models\Group;

class GroupController extends BaseController {

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add()
    {
        $ingredientsData = Helper::ingredientsData(auth()->user());
        foreach ($ingredientsData as $key => $ingredient) {
            $data = $ingredient;

            $data['key'] = $key;
            $data['selected'] = false;
            $data['amount'] = 1;

            $ingredientsData[$key] = $data;
        }

        return view('home.create-group', compact('ingredientsData'));
    }

    public function edit(Group $group)
    {
        $ingredientsData = Helper::ingredientsData(auth()->user());
        foreach ($ingredientsData as $key => $ingredient) {
            $data = $ingredient;

            $selected = false;
            $amount = 1;

            foreach ($group->ingredients as $groupIngredient) {
                if ($groupIngredient->id === $ingredient['id']) {
                    $selected = true;
                    $amount = (float) $groupIngredient->pivot->amount;
                }
            }

            $data['key'] = $key;
            $data['selected'] = $selected;
            $data['amount'] = $amount;

            $ingredientsData[$key] = $data;
        }

        return view('home.edit-group', compact('group', 'ingredientsData'));
    }

}
