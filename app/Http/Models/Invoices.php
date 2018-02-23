<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\BinaryUuid\HasBinaryUuid;

class Invoices extends Model {

    use HasBinaryUuid;

    protected $guarded = [];
    public $timestamps = false;

}