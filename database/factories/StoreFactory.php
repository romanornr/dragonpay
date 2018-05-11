<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Models\Shop::class, function (Faker $faker){
   return [
       'name' => 'Mining-Rigs',
       'website' => $faker->unique()->name,
       'expiration_time' => $faker->numberBetween(15, 500),
       'user_id' => factory(User::class)->create()->id
   ];
});