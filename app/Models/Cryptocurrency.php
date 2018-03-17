<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Cryptocurrency extends Model {

    /**
     * table cryptocurrencies
     * @var string
     */
    protected $table = 'cryptocurrencies';

    protected $guarded = ['id'];
    public $timestamps = false;

}
