<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function items() {
        return $this->belongsToMany('App\Models\Item')->withPivot('amount');
    }

    public function itemsByLocation()
    {
        $locations = [];

        foreach ($this->items as $item) {
            if (empty($locations[$item->location_id])) {
                $items[$item->location_id] = [];
            }

            $locations[$item->location_id][] = $item;
        }

        return $locations;
    }
}
