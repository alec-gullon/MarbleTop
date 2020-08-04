<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemLocation extends Model
{
    protected $fillable = ['name'];

    public function user() {
        return $this->hasMany('App\Models\Item');
    }
}
