<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token'
    ];

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

    public function meals()
    {
        return $this->hasMany('App\Models\Meal');
    }

    public function groups()
    {
        return $this->hasMany('App\Models\Group');
    }

    public function plans()
    {
        return $this->hasMany('App\Models\Plan');
    }

    public function addMeal($attributes)
    {
        return $this->meals()->create($attributes);
    }

    public function addGroup($name)
    {
        return $this->groups()->create(compact('name'));
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

    public function hasMeal($name)
    {
        return ($this->meals->where('name', $name)->first() !== null);
    }
}
