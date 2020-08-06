<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CreateSeriesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_user_can_create_a_series()
    {
        $this->withoutExceptionHandling();

        Storage::fake(config('filesystems.default'));

        $this->post('/admin/series', [
            'title' => 'vue.js is the best',
            'description' => 'the best vue.js casts ever',
            'image' => UploadedFile::fake()->image('image-series.png')
        ])->assertRedirect();

        Storage::disk(config('filesystems.default'))->assertExists(
            'series/' . str_slug('vue.js is the best') . '.png'
        );

        $this->assertDatabaseHas('series', [
            'slug' => str_slug('vue.js is the best')
        ]);
    }
}
