<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Shop extends Model {

    protected $table = 'shops';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function masterwallets()
    {
        return $this->hasMany('App\Models\Masterwallet');
    }
}
