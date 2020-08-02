<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Illuminate\Routing\Controller as BaseController;

use App\Models\Group;

class GroupController extends BaseController
{
    public function add(Request $request)
    {
        $request->ingredients = json_decode($request->ingredients);

        $user = auth()->user();

        $groups = $user->groups->where('name', $request->name);
        if (count($groups) !== 0) {
            return json_encode([
                'status' => 400,
                'error' => 'mealAlreadyExists'
            ]);
        }

        $group = new Group();
        $group->user_id = $user->id;
        $group->name = $request->name;
        $group->save();

        foreach ($request->ingredients as $ingredient) {
            $group->ingredients()->attach(
                $ingredient->id, ['amount' => $ingredient->amount,]
            );
        }

        $request->session()->flash('message', 'Successfully added group!');

        $response = ['status' => 200];
        return json_encode($response);
    }

    public function update(Group $group, Request $request)
    {
        $request->ingredients = json_decode($request->ingredients);
        $user = auth()->user();

        if ($group->name !== $request->name) {
            $groups = $user->groups->where('name', $request->name);
            if (count($groups) !== 0) {
                return json_encode([
                    'status' => 400,
                    'error' => 'groupAlreadyExists'
                ]);
            }
        }

        $group->name = $request->name;
        $group->save();

        $group->ingredients()->detach();

        foreach ($request->ingredients as $ingredient) {
            $group->ingredients()->attach(
                $ingredient->id, ['amount' => $ingredient->amount,]
            );
        }

        $request->session()->flash('message', 'Successfully updated group!');

        $response = ['status' => 200];
        return json_encode($response);
    }

    public function delete(Group $group, Request $request)
    {
        $group->ingredients()->detach();
        $group->delete();

        $request->session()->flash('message', 'Successfully deleted group!');
        return json_encode(['status' => 200]);
    }
}
