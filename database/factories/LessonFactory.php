<?php

use Faker\Generator as Faker;
use HappyCasts\Lesson;
use HappyCasts\Series;

$factory->define(Lesson::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(3),
        'description' => $faker->paragraph(3),
        'series_id' => function () {
            return factory(Series::class)->create()->id;
        },
        'episode_number' => 100,
        'video_id' => '1234567890'
    ];
});
