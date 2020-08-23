<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use HappyCasts\User;

class CreateSeriesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test a user can create a series
     *
     * @return void
     */
    public function test_a_user_can_create_a_series()
    {
        $this->withoutExceptionHandling();

        $this->loginAdmin();

        Storage::fake(config('filesystems.default'));

        $this->post('/admin/series', [
            'title' => 'vue.js is the best',
            'description' => 'the best vue.js casts ever',
            'image' => UploadedFile::fake()->image('image-series.png')
        ])->assertRedirect()
            ->assertSessionHas('success', 'Series created successfully');

        Storage::disk(config('filesystems.default'))->assertExists(
            'public/series/' . str_slug('vue.js is the best') . '.png'
        );

        $this->assertDatabaseHas('series', [
            'slug' => str_slug('vue.js is the best')
        ]);
    }

    /**
     * test a series must be created with a title
     *
     * @return void
     */
    public function test_a_series_must_be_created_with_a_title()
    {
        $this->loginAdmin();

        $this->post('/admin/series', [
            'description' => 'the best vue.js casts ever',
            'image' => UploadedFile::fake()->image('image-series.png')
        ])->assertSessionHasErrors('title');
    }

    /**
     * test a series must be created with a description
     *
     * @return void
     */
    public function test_a_series_must_be_created_with_a_description()
    {
        $this->loginAdmin();

        $this->post('/admin/series', [
            'title' => 'vue.js is the best',
            'image' => UploadedFile::fake()->image('image-series.png')
        ])->assertSessionHasErrors('description');
    }

    /**
     * test a series must be created with a image
     *
     * @return void
     */
    public function test_a_series_must_be_created_with_a_image()
    {
        $this->loginAdmin();

        $this->post('/admin/series', [
            'title' => 'vue.js is the best',
            'description' => 'the best vue.js casts ever'
        ])->assertSessionHasErrors('image');
    }

    /**
     * test a series must be created with an image which is actually an image
     *
     * @return void
     */
    public function test_a_series_must_be_created_with_an_image_which_is_actually_an_image()
    {
        $this->loginAdmin();

        $this->post('/admin/series', [
            'title' => 'vue.js is the best',
            'description' => 'the best vue.js casts ever',
            'image' => 'STRING_INVALID_IMAGE'
        ])->assertSessionHasErrors('image');
    }

    /**
     * test only administrators can create series
     *
     * @return void
     */
    public function test_only_administrators_can_create_series()
    {

        //cretae user
        $this->actingAs(
            factory(User::class)->create()
        );
        //visit endpoint
        $this->post('/admin/series')
            ->assertSessionHas('error', 'You are not authorized to perform this action');
    }
}
