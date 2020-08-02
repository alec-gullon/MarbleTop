<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = ['name', 'location_id', 'user_id'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function location() {
        return $this->belongsTo('App\Models\IngredientLocation');
    }

    public function meals() {
        return $this->belongsToMany('App\Models\Meal');
    }

    public function plans() {
        return $this->belongsToMany('App\Models\Ingredient');
    }
}
