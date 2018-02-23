<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Stores extends Model {

    protected $table = 'stores';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
