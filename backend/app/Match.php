<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $fillable = [
        'team_name',
    ];

    public function players()
    {
        return $this->belongsToMany(User::class);
    }
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function addPlayer($user)
    {
        $this->players()->attach($user);
    }
    public function removePlayer($user)
    {
        $this->players()->detach($user);
    }

    public function hasPlayer($user)
    {
        return $this->players()->find($user);
    }
}
