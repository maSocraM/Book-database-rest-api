<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/


// Publisher Model Faker seeder
$factory->define(App\Publisher::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company //$faker->name,
    ];
});

// Author Model Faker seeder
$factory->define(App\Author::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'editorial_name' => $faker->name,
        'link' => $faker->url,
    ];
});

// Book Model Faker seeder
$factory->define(App\Book::class, function (Faker\Generator $faker) {
     
    $publishers = \App\Publisher::pluck('id')->all();
    
    return [
        'title' => "$faker->paragraph",
        'publisher_id' => $faker->randomElement($publishers),
        'publish_date' => $faker->dateTime,
        'isbn' => $faker->isbn10,
        'isbn_thirteen' => $faker->isbn13,
        'description' => "$faker->text",
        'highlight' => $faker->boolean,
    ];
});
