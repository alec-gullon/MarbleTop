<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

use App\Helper;

use App\Models\Group;

class GroupController extends Controller
{
    public function index()
    {
        $groups = \App\Helper::groupsData(auth()->user());

        return view('home.collections.index', compact('groups'));
    }

    public function show()
    {
        $itemsData = Helper::itemsData(auth()->user());
        foreach ($itemsData as $key => $item) {
            $data = $item;

            $data['key'] = $key;
            $data['selected'] = false;
            $data['amount'] = 1;

            $itemsData[$key] = $data;
        }

        return view('home.collections.create-collection', compact('itemsData'));
    }

    public function edit(Group $group)
    {
        $itemsData = Helper::itemsData(auth()->user());
        foreach ($itemsData as $key => $item) {
            $data = $item;

            $selected = false;
            $amount = 1;

            foreach ($group->items as $groupItem) {
                if ($groupItem->id === $item['id']) {
                    $selected = true;
                    $amount = (float) $groupItem->pivot->amount;
                }
            }

            $data['key'] = $key;
            $data['selected'] = $selected;
            $data['amount'] = $amount;

            $itemsData[$key] = $data;
        }

        return view('home.collections.edit-collection', compact('group', 'itemsData'));
    }
}
