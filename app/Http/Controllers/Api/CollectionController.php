<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Requests\Api\Collection\DestroyCollection;
use App\Http\Requests\Api\Collection\StoreCollection;
use App\Http\Requests\Api\Collection\UpdateCollection;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller as BaseController;

use App\Models\Collection;

class CollectionController extends BaseController
{
    public function store(StoreCollection $request)
    {
        $user = auth()->user();
        $request->items = json_decode($request->items, true);

        if ($user->hasCollection($request->name)) {
            return ApiResponse::error(['error' => 'collectionAlreadyExists']);
        }

        $collection = $user->addCollection(
            $request->only('name')
        );

        $collection->attachItems($request->items);

        $request->session()->flash('message', 'Successfully added collection!');

        return ApiResponse::success();
    }

    public function update(UpdateCollection $request, Collection $collection)
    {
        $user = auth()->user();
        $request->items = json_decode($request->items, true);

        if ($collection->name !== $request->name && $user->hasCollection($request->name)) {
            return ApiResponse::error(['error' => 'collectionAlreadyExists']);
        }

        $collection->update(
            $request->only('name')
        );

        $collection->items()->detach();

        $collection->attachItems($request->items);

        $request->session()->flash('message', 'Successfully updated collection!');

        return ApiResponse::success();
    }

    public function destroy(DestroyCollection $request, Collection $collection)
    {
        $collection->delete();

        $request->session()->flash('message', 'Successfully deleted collection!');
        return ApiResponse::success();
    }
}