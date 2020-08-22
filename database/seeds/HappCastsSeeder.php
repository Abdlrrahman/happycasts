<?php

use HappyCasts\User;
use HappyCasts\Lesson;
use HappyCasts\Series;
use Illuminate\Database\Seeder;

class HappyCastsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => bcrypt('secret'),
        ]);
        factory(Series::class, 5)
            ->create()
            ->each(function ($series) {
                factory(Lesson::class, 10)->create([
                    'series_id' => $series->id
                ]);
            });
    }
}
