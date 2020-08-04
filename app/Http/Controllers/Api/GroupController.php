<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Requests\Api\Group\DestroyGroup;
use App\Http\Requests\Api\Group\StoreGroup;
use App\Http\Requests\Api\Group\UpdateGroup;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller as BaseController;

use App\Models\Group;

class GroupController extends BaseController
{
    public function store(StoreGroup $request)
    {
        $user = auth()->user();
        $request->items = json_decode($request->items, true);

        if ($user->hasGroup($request->name)) {
            return ApiResponse::error(['error' => 'groupAlreadyExists']);
        }

        $group = $user->addGroup(
            $request->only('name')
        );

        $group->attachItems($request->items);

        $request->session()->flash('message', 'Successfully added group!');

        return ApiResponse::success();
    }

    public function update(UpdateGroup $request, Group $group)
    {
        $user = auth()->user();
        $request->items = json_decode($request->items, true);

        if ($group->name !== $request->name && $user->hasGroup($request->name)) {
            return ApiResponse::error(['error' => 'groupAlreadyExists']);
        }

        $group->update(
            $request->only('name')
        );

        $group->items()->detach();

        $group->attachItems($request->items);

        $request->session()->flash('message', 'Successfully updated group!');

        return ApiResponse::success();
    }

    public function destroy(DestroyGroup $request, Group $group)
    {
        $group->delete();

        $request->session()->flash('message', 'Successfully deleted group!');
        return ApiResponse::success();
    }
}
