<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Arr;

class Recipe extends Model
{
    protected $guarded = [];

    public static $expectedCookTimes = [
        0, 10, 20, 30, 45, 60, 90, 120
    ];

    public static $expectedServingSizes = [
        0, 1, 2, 3, 4, 5, 6
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function items() {
        return $this->belongsToMany('App\Models\Item')->withPivot('amount', 'order', 'precise_amount')->orderBy('order');
    }

    public function apiPath() {
        return '/api/recipes/' . $this->id . '/';
    }

    public function imagePath() {
        return '/images/food/food-' . $this->image_id . '.jpg';
    }

    public function attachItems($items) {
        foreach ($items as $item) {
            $this->items()->attach(
                $item['id'],
                Arr::only($item, ['amount', 'precise_amount', 'order'])
            );
        }
    }

    public function toggleStatus() {
        $this->update(['published' => !$this->published]);
    }

    public function displayRecipe() {
        $parts = $this->recipeParts();
        $recipe = implode('</p><p>', $parts);
        return '<p>' . $recipe . '</p>';
    }

    public function recipeParts() {
        return preg_split("/(\n\s\n){1,}|(\n){1,}|(\r\n){1,}/", $this->recipe);
    }

    public function primaryItems() {
        $primaryItems = [];
        foreach ($this->items as $item) {
            if (!empty($item->pivot->precise_amount)) {
                $primaryItems[] = $item;
            }
        }
        return $primaryItems;
    }

    public function secondaryItems() {
        $secondaryItems = [];
        foreach ($this->items as $item) {
            if (empty($item->pivot->precise_amount)) {
                $secondaryItems[] = $item;
            }
        }
        return $secondaryItems;
    }
}
