<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name', 'location_id', 'user_id'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function location() {
        return $this->belongsTo('App\Models\ItemLocation');
    }

    public function recipes() {
        return $this->belongsToMany('App\Models\Recipe');
    }

    public function plans() {
        return $this->belongsToMany('App\Models\Item');
    }

    public function apiPath() {
        return '/api/items/' . $this->id . '/';
    }
}
