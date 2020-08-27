<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;

use App\Http\Requests\Api\Recipe\StoreRecipe;
use App\Http\Requests\Api\Recipe\UpdateRecipe;
use App\Http\Requests\Api\Recipe\DestroyRecipe;

use App\Models\Recipe;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

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

        if (!empty($request->cook_time) && !in_array($request->cook_time, Recipe::$expectedCookTimes)) {
            return ApiResponse::error(['error' => 'invalidCookTime']);
        }

        if (!empty($request->serving_size) && !in_array($request->serving_size, Recipe::$expectedServingSizes)) {
            return ApiResponse::error(['error' => 'invalidServingSize']);
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
        if ($recipe->published) {
            $recipe->update([
                'slug' => '',
                'published' => false
            ]);
        } else {
            if (empty($recipe->description)) {
                return ApiResponse::error(['error' => 'descriptionIsRequired']);
            }
            if (empty($recipe->serving_size)) {
                return ApiResponse::error(['error' => 'servingSizeIsRequired']);
            }
            if (empty($recipe->cook_time)) {
                return ApiResponse::error(['error' => 'cookTimeIsRequired']);
            }

            $slug = Str::slug($recipe->name);
            if (Recipe::where('slug', $slug)->count()) {
                $slug = $slug . '-' . $recipe->user->id;
            }

            $recipe->update([
                'slug' => $slug,
                'published' => true
            ]);
        }

        return ApiResponse::success();
    }

    public function updateImage(Request $request, Recipe $recipe) {
        $recipe->update(
            $request->only('image_id')
        );

        return ApiResponse::success();
    }
}
