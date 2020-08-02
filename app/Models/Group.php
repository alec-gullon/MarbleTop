<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name', 'user_id'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function ingredients() {
        return $this->belongsToMany('App\Models\Ingredient')->withPivot('amount');
    }
}
