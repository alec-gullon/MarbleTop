<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Arr;

class Meal extends Model
{
    protected $fillable = ['name', 'user_id', 'recipe'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function items() {
        return $this->belongsToMany('App\Models\Item')->withPivot('amount', 'order', 'preciseAmount');
    }

    public function apiPath() {
        return '/api/meals/' . $this->id . '/';
    }

    public function attachItems($items) {
        foreach ($items as $item) {
            $this->items()->attach(
                $item['id'],
                Arr::only($item, ['amount', 'preciseAmount', 'order'])
            );
        }
    }

    public function displayRecipe() {
        $parts = explode('/n\s*\n/', $this->recipe);
        $recipe = implode('</p><p>', $parts);
        return '<p>' . $recipe . '</p>';
    }
}
