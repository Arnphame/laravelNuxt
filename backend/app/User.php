<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role',
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

    public function games()
    {
        return $this->belongsToMany(Game::class);
    }
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
        if($this->games_played == 10) {
            $this->badge = "Silver";
        }
        if($this->games_played == 20) {
            $this->badge = "Gold";
        }
        if($this->games_played == 30) {
            $this->badge = "Diamond";
        }
        if($this->games_played == 40) {
            $this->badge = "Platinum";
        }
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
