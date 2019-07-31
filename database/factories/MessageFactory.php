<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Message;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Message::class, function (Faker $faker) {
    return [
        'subject' => $faker->sentence(5),
        'content' => $faker->text(100),
        'sender_id' => 2,
        'sender_type' => 'App\Student',
        'recipient_id' => 1,
        'recipient_type' => 'App\Student',
        'status' => 'new',
    ];
});