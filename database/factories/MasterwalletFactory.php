<?php

use Faker\Generator as Faker;
use App\Models\Store;

$factory->define(App\Models\Masterwallet::class, function (Faker $faker){

    $store = factory(Store::class)->create();

   return [
       'cryptocurrency_id' => 1,
       'user_id' => $store->user_id,
       'store_id' => $store->id,
       'address_type' => 'segwit',
       'script_type' => 'p2sh',
       'master_public_key' => 'xpub6DBfFoZHK5ZCzuoViVTzmRTf91DEVvYoifJQToHhHAwS2pmyeQCfQ5pqCg65WYBB2jnyDtoPRdpLVgwH5UpFswFX1qNtD4ccpZJXB9fqkQA'
   ];
});
