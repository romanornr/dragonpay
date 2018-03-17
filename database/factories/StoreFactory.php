<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Models\Store::class, function (Faker $faker){
   return [
       'name' => $faker->name,
       'website' => $faker->unique()->name,
       'min_confirmations' => $faker->numberBetween(0, 200),
       'expiration_time' => $faker->numberBetween(15, 500),
       'user_id' => factory(User::class)->create()->id
   ];
});