<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Requests\Api\Item\StoreItem;
use App\Http\Requests\Api\Item\UpdateItem;
use App\Http\Requests\Api\Item\DestroyItem;
use App\Models\Item;
use App\Vue\ItemsAdmin;

use Illuminate\Routing\Controller as BaseController;

class ItemController extends BaseController
{
    /**
     * Creates and stores a new Item model
     *
     * @param   StoreItem   $request
     * @return  string
     */
    public function store(StoreItem $request)
    {
        $user = auth()->user();

        if ($user->hasItem($request->name)) {
            return ApiResponse::error(['error' => 'itemAlreadyExists']);
        }

        $user->addItem(
            $request->only(['name', 'location_id'])
        );

        return ApiResponse::success(['items' => ItemsAdmin::items()]);
    }

    /**
     * Updates the specified $item model
     *
     * @param   UpdateItem  $request
     * @param   Item        $item
     *
     * @return  string
     */
    public function update(UpdateItem $request, Item $item)
    {
        $user = auth()->user();

        if ($item->name !== $request->name && $user->hasItem($request->name)) {
            return ApiResponse::error(['error' => 'itemAlreadyExists']);
        }

        $item->update(
            $request->only(['name', 'location_id'])
        );

        return ApiResponse::success(['items' => ItemsAdmin::items()]);
    }

    /**
     * Deletes the specified $item model
     *
     * @param   DestroyItem     $request
     * @param   Item            $item
     *
     * @return  string
     */
    public function destroy(DestroyItem $request, Item $item)
    {
        $item->delete();

        return ApiResponse::success(['items' => ItemsAdmin::items()]);
    }
}
