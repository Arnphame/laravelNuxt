<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'location', 'start_at', 'status',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function addUser($user)
    {
        $this->users()->attach($user);
    }
    public function removeUser($user)
    {
        $this->users()->detach($user);
    }

    public function hasUser($user)
    {
        return $this->users()->find($user);
    }
<<<<<<< HEAD

    public function matches()
    {
        return $this->hasMany(Match::class);
    }
    //
=======
>>>>>>> 63fc4363079e87c7b699acd17b009c2c145604b1
}
