<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Arr;

class Recipe extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function items() {
        return $this->belongsToMany('App\Models\Item')->withPivot('amount', 'order', 'precise_amount')->orderBy('order');
    }

    public function apiPath() {
        return '/api/recipes/' . $this->id . '/';
    }

    public function attachItems($items) {
        foreach ($items as $item) {
            $this->items()->attach(
                $item['id'],
                Arr::only($item, ['amount', 'precise_amount', 'order'])
            );
        }
    }

    public function displayRecipe() {
        $parts = preg_split("/(\n\s\n){1,}|(\n){1,}|(\r\n){1,}/", $this->recipe);
        $recipe = implode('</p><p>', $parts);
        return '<p>' . $recipe . '</p>';
    }
}
