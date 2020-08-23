<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use HappyCasts\Series;

class UpdateSeriesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test a user can update a series
     *
     * @return void
     */
    public function test_a_user_can_update_a_series()
    {
        $this->withoutExceptionHandling();
        // login as admin
        $this->loginAdmin();

        //put request to the specified endpoint
        $series = factory(Series::class)->create();

        Storage::fake(config('filesystems.default'));

        $this->put(route('series.update', $series->slug), [
            'title' => 'new series title',
            'description' => 'new series description',
            'image' => UploadedFile::fake()->image('image-series.png')
        ])->assertRedirect(route('series.index'))
            ->assertSessionHas('success', 'Successfully updated series');

        //assert storage image
        Storage::disk(config('filesystems.default'))->assertExists(
            'public/series/' . str_slug('new series title') . '.png'
        );

        //assert that the db has the series
        $this->assertDatabaseHas('series', [
            'slug' => str_slug('new series title'),
            'image_url' => 'series/new-series-title.png'
        ]);
    }

    /**
     * test an image is not required to update a series
     *
     * @return void
     */
    public function test_an_image_is_not_required_to_update_a_series()
    {
        $this->withoutExceptionHandling();

        // login as admin
        $this->loginAdmin();

        //put request to the specified endpoint 
        $series = factory(Series::class)->create();

        Storage::fake(config('filesystems.default'));

        $this->put(route('series.update', $series->slug), [
            'title' => 'new series title',
            'description' => 'new series description'
        ])->assertRedirect(route('series.index'))
            ->assertSessionHas('success', 'Successfully updated series');

        //assert storage image
        Storage::disk(config('filesystems.default'))->assertMissing(
            'series/' . str_slug('new series title') . '.png'
        );

        //assert that the db has the series
        $this->assertDatabaseHas('series', [
            'slug' => str_slug('new series title'),
            'image_url' => $series->image_url
        ]);
    }
}
