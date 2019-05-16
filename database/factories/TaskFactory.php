<?php

use Faker\Generator as Faker;

$factory->define( App\Task::class, function ( Faker $faker ) {

    return [

        'body'       => $faker->paragraph,
        'project_id' => factory( \App\Project::class )
        // this method of passing a factory instance is a shortcut to wrapping this same call within a closure function
    ];
});
