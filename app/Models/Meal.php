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

    public function ingredients() {
        return $this->belongsToMany('App\Models\Ingredient')->withPivot('amount', 'order', 'preciseAmount');
    }

    public function apiPath() {
        return '/api/meals/' . $this->id . '/';
    }

    public function attachIngredients($ingredients) {
        foreach ($ingredients as $ingredient) {
            $this->ingredients()->attach(
                $ingredient['id'],
                Arr::only($ingredient, ['amount', 'preciseAmount', 'order'])
            );
        }
    }
}
