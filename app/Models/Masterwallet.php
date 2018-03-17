<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Masterwallet extends Model {

    /**
     * table masterwallets
     * @var string
     */
    protected $table = 'masterwallets';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function stores()
    {
        return $this->belongsTo('App\Models\Store', 'store_id');
    }

    public function cryptocurrency()
    {
        return $this->belongsTo('App\Models\Cryptocurrency', 'cryptocurrency_id');
    }

}
