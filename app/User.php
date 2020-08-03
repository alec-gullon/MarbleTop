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

    public function ingredients()
    {
        return $this->hasMany('App\Models\Ingredient');
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

    public function addMeal($name, $recipe)
    {
        return $this->meals()->create(compact('name', 'recipe'));
    }

    public function addGroup($name)
    {
        return $this->groups()->create(compact('name'));
    }

    public function addPlan()
    {
        return $this->plans()->create();
    }

    public function addIngredient($attributes)
    {
        return $this->ingredients()->create($attributes);
    }

    public function hasIngredient($name)
    {
        return ($this->ingredients->where('name', $name)->first() !== null);
    }
}
