<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;

use App\Models\Item;
use App\Helper;
use App\Helpers\ApiResponse;

use App\Http\Requests\Api\Item\StoreItem;
use App\Http\Requests\Api\Item\UpdateItem;
use App\Http\Requests\Api\Item\DestroyItem;

class ItemController extends BaseController
{
    public function store(StoreItem $request)
    {
        $user = auth()->user();

        if ($user->hasItem($request->name)) {
            return ApiResponse::error(['error' => 'itemAlreadyExists']);
        }

        $user->addItem(
            $request->only(['name', 'location_id'])
        );

        return ApiResponse::success(['items' => Helper::itemsData($user)]);
    }

    public function update(UpdateItem $request, Item $item)
    {
        $user = auth()->user();

        if ($item->name !== $request->name && $user->hasItem($request->name)) {
            return ApiResponse::error(['error' => 'itemAlreadyExists']);
        }

        $item->update(
            $request->only(['name', 'location_id'])
        );

        return ApiResponse::success(['items' => Helper::itemsData($user)]);
    }

    public function destroy(DestroyItem $request, Item $item)
    {
        $item->delete();

        return ApiResponse::success(['items' => Helper::itemsData(auth()->user())]);
    }
}
