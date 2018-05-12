<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\BinaryUuid\HasBinaryUuid;

class Invoice extends Model {

    use HasBinaryUuid;

    /**
     * table invoices
     * @var string
     */
    protected $table = 'invoices';

    protected $guarded = ['uuid'];

    public function getKeyName()
    {
        return 'uuid';
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function shop()
    {
        return $this->belongsTo('App\Models\Shop', 'store_id');
    }

    public function cryptocurrency()
    {
        return $this->belongsTo('App\Models\Cryptocurrency', 'cryptocurrency_id');
    }

}