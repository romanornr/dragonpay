<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token',
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

//    /**
//     * All of the relationships to be touched.
//     *
//     * @var array
//     */
//    protected $touches = ['store'];

    public function masterwallets()
    {
        return $this->hasMany('App\Models\Masterwallet');
    }

    public function stores()
    {
        return $this->hasMany('App\Models\Store');
    }

    public function invoices()
    {
        return $this->hasMany('App\Models\Invoices');
    }
}
