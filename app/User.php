<?php

namespace App;

// use Laravel\Passport\HasApiTokens;
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
          'name'
        , 'username'
        , 'email'
        , 'password'
        , 'user_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }
}
