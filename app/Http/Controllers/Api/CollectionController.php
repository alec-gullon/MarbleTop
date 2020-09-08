<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Requests\Api\Collection\DestroyCollection;
use App\Http\Requests\Api\Collection\StoreCollection;
use App\Http\Requests\Api\Collection\UpdateCollection;
use App\Models\Collection;

use Illuminate\Routing\Controller as BaseController;

class CollectionController extends BaseController
{
    /**
     * Creates and stores a new Collection model
     *
     * @param   StoreCollection     $request
     * @return  string
     */
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

    /**
     * Updates the specified $collection model
     *
     * @param   UpdateCollection    $request
     * @param   Collection          $collection
     *
     * @return  string
     */
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

    /**
     * Deletes the specified $collection model
     *
     * @param DestroyCollection $request
     * @param Collection $collection
     *
     * @return  string
     */
    public function destroy(DestroyCollection $request, Collection $collection)
    {
        $collection->delete();

        $request->session()->flash('message', 'Successfully deleted collection!');
        return ApiResponse::success();
    }
}
