<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemLocation extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->hasMany('App\Models\Item');
    }
}
