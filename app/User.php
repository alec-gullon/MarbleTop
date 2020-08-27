<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }

    public function recipes()
    {
        return $this->hasMany('App\Models\Recipe');
    }

    public function publishedRecipes()
    {
        return $this->recipes()->where('published', true)->get();
    }

    public function collections()
    {
        return $this->hasMany('App\Models\Collection');
    }

    public function plans()
    {
        return $this->hasMany('App\Models\Plan');
    }

    public function addRecipe($attributes)
    {
        return $this->recipes()->create($attributes);
    }

    public function addCollection($attributes)
    {
        return $this->collections()->create($attributes);
    }

    public function addPlan()
    {
        return $this->plans()->create();
    }

    public function addItem($attributes)
    {
        return $this->items()->create($attributes);
    }

    public function hasItem($name)
    {
        return ($this->items->where('name', $name)->first() !== null);
    }

    public function hasRecipe($name)
    {
        return ($this->recipes->where('name', $name)->first() !== null);
    }

    public function hasCollection($name)
    {
        return ($this->collections->where('name', $name)->first() !== null);
    }
}
