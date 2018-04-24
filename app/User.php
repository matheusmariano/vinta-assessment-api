<?php

namespace App;

use Illuminate\Notifications\Notifiable;
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
        'name', 'email', 'password', 'provider', 'provider_id',
    ];

    protected $append = [
        'commits',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function repositories()
    {
        return $this->hasMany(Repository::class);
    }

    public function commits()
    {
        return $this->hasManyThrough(Commit::class, Repository::class);
    }

    public function scopeFindByGithubId($scope, $id)
    {
        return $scope
            ->where([
                ['provider', '=', 'github'],
                ['provider_id', '=', $id],
            ])
            ->first();
    }
}
