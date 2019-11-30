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
        $this->users()->create($user);
    }

    public function hasUser($user)
    {
        return $this->users()->find($user);
    }
    //
}
