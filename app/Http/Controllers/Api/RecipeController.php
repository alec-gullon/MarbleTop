<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;

use App\Http\Requests\Api\Recipe\StoreRecipe;
use App\Http\Requests\Api\Recipe\UpdateRecipe;
use App\Http\Requests\Api\Recipe\DestroyRecipe;

use App\Models\Recipe;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class RecipeController extends BaseController
{
    public function store(StoreRecipe $request)
    {
        $user = auth()->user();
        $request->items = json_decode($request->items, true);

        if ($user->hasRecipe($request->name)) {
            return ApiResponse::error(['error' => 'recipeAlreadyExists']);
        }

        $recipe = $user->addRecipe(
            $request->only('name', 'recipe', 'description', 'image_id', 'serving_size', 'cook_time')
        );

        $recipe->attachItems($request->items);

        $request->session()->flash('message', 'Successfully added recipe!');

        return ApiResponse::success();
    }

    public function update(UpdateRecipe $request, Recipe $recipe)
    {
        $user = auth()->user();
        $request->items = json_decode($request->items, true);

        if ($recipe->name !== $request->name && $user->hasRecipe($request->name)) {
            return ApiResponse::error(['error' => 'recipeAlreadyExists']);
        }

        $recipe->update(
            $request->only('name', 'recipe', 'description', 'image_id', 'serving_size', 'cook_time')
        );

        $recipe->items()->detach();

        $recipe->attachItems($request->items);

        $request->session()->flash('message', 'Successfully updated recipe!');

        return ApiResponse::success();
    }

    public function destroy(DestroyRecipe $request, Recipe $recipe)
    {
        $recipe->delete();

        $request->session()->flash('message', 'Successfully deleted recipe!');
        return ApiResponse::success();
    }

    public function togglePublishStatus(Recipe $recipe) {
        $recipe->toggleStatus();

        return ApiResponse::success();
    }

    public function updateImage(Request $request, Recipe $recipe) {
        $recipe->update(
            $request->only('image_id')
        );

        return ApiResponse::success();
    }
}
