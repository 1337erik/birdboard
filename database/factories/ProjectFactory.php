<?php

use Faker\Generator as Faker;

$factory->define(App\Project::class, function (Faker $faker) {

    return [

        'title'       => $faker->sentence( 2 ), // only create 2 words for title
        'description' => $faker->paragraph,
        'owner_id'    => function(){

            return factory( App\User::class )->create()->id;
        }
    ];
});
