<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = ['name', 'user_id', 'recipe'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function ingredients() {
        return $this->belongsToMany('App\Models\Ingredient')->withPivot('amount', 'order', 'preciseAmount');
    }
}
