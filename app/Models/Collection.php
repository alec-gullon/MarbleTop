<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Collection extends Model
{
    protected $fillable = ['name', 'user_id'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function items() {
        return $this->belongsToMany('App\Models\Item')->withPivot('amount');
    }

    public function apiPath() {
        return '/api/collections/' . $this->id . '/';
    }

    public function attachItems($items) {
        foreach ($items as $item) {
            $this->items()->attach(
                $item['id'],
                Arr::only($item, ['amount'])
            );
        }
    }
}
