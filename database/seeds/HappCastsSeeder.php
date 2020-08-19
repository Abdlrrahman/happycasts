<?php

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
            'email' => 'test@test.com',
        ]);
        factory(Series::class, 5)
            ->create()
            ->each(function ($series) {
                $x = 0;
                factory(Lesson::class, 10)->create([
                    'series_id' => $series->id,
                    'episode_number' => $x++
                ]);
            });
    }
}
