<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tweet;
use Faker\Generator as Faker;

$factory->define(Tweet::class, function (Faker $faker) {
    for( $keywords=[],$n=rand(0,5) ;  $n>0 ; $n-- ) {
        $keywords[] = $faker->lastName;
    }

    return [
        'twitter_id' => rand(100000,999999).rand(100000,999999).rand(100000,999999),
        'message' => $faker->paragraph(),
        'ignore' => $faker->boolean(),
    ];
});
