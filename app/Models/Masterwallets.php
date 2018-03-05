<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Masterwallets extends Model {

    /**
     * table masterwallets
     * @var string
     */
    protected $table = 'masterwallets';

    protected $guarded = ['id'];

    public function cryptocurrency()
    {
        return $this->belongsTo('App\Models\Cryptocurrencies', 'cryptocurrency_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function stores()
    {
        return $this->belongsTo('App\Models\Stores', 'store_id');
    }

}
