<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Models\Masterwallet::class, function (Faker $faker){
   return [
       'cryptocurrency_id' => 1,
       'user_id' => factory(User::class)->create()->id,
       'store_id' => $faker->numberBetween(0, 200),
       'address_type' => $faker->numberBetween(15, 500),
       'script_type' => ''
   ];
});
