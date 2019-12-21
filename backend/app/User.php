<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;



class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function games()
    {
        return $this->belongsToMany(Game::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function matches()
    {
        return $this->belongsToMany(Match::class);
    }

    public function deleteFromMatch($user)
    {
        return $this->matches()->detach($user);
    }

    public function addGamesPlayed()
    {
        $this->games_played = $this->games_played + 1;
    }

    public function changeBadge()
    {
        if ($this->games_played == 10) {
            $this->badge = "Silver";
        }
        if ($this->games_played == 20) {
            $this->badge = "Gold";
        }
        if ($this->games_played == 30) {
            $this->badge = "Diamond";
        }
        if ($this->games_played == 40) {
            $this->badge = "Platinum";
        } else {
            $this->badge = "Bronze";
        }
    }

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
