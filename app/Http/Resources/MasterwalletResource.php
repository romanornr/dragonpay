<?php

namespace App\Http\Resources;

use App\Models\Cryptocurrency;
use Illuminate\Http\Resources\Json\Resource;
use DragonPay\CryptoCurrencies\CryptocurrencyFactory;
use DragonPay\Address\AddressFactory as Address;

class MasterwalletResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
