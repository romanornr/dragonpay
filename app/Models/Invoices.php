<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\BinaryUuid\HasBinaryUuid;

class Invoices extends Model {

    use HasBinaryUuid;

    /**
     * table invoices
     * @var string
     */
    protected $table = 'invoices';

    protected $guarded = ['uuid'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function store()
    {
        return $this->belongsTo('App\Models\Stores', 'stores_id');
    }

}