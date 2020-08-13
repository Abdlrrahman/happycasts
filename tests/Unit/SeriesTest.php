<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use HappyCasts\Series;

class SeriesTest extends TestCase
{
    /**
     * A basic test.
     *
     * @return void
     */
    public function test_series_can_get_image_path()
    {
        $series = factory(Series::class)->create([
            'image_url' => 'series/series-slug.png'
        ]);

        $imagePath = $series->image_path;
        $this->assertEquals(asset('storage/series/series-slug.png'), $imagePath);
    }
}
