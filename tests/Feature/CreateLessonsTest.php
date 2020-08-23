<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use HappyCasts\Series;

class CreateLessonsTest extends TestCase
{

    use RefreshDatabase;

    /**
     * test a user can create lessons
     *
     * @return void
     */
    public function test_a_user_can_create_lessons()
    {
        $this->loginAdmin();
        $this->withoutExceptionHandling();

        //admin/id/lessons
        $series = factory(Series::class)->create();

        //data
        $lesson = [
            "title" => 'new lesson',
            'description' => 'new lesson description',
            'episode_number' => 1,
            'video_id' => 1234567890
        ];

        $this->postJson("/admin/{$series->id}/lessons", $lesson)
            ->assertStatus(200)
            ->assertJson($lesson);

        $this->assertDatabaseHas('lessons', [
            'title' => $lesson['title']
        ]);
    }

    /**
     * test a title is required to create a lesson
     *
     * @return void
     */
    public function test_a_title_is_required_to_create_a_lesson()
    {
        $this->loginAdmin();
        //admin/id/lessons
        $series = factory(Series::class)->create();

        //data
        $lesson = [
            'description' => 'new lesson description',
            'episode_number' => 1,
            'video_id' => 1234567890
        ];
        $this->post("/admin/{$series->id}/lessons", $lesson)
            ->assertSessionHasErrors('title');
    }

    /**
     * test a description is required to create a lesson
     *
     * @return void
     */
    public function test_a_description_is_required_to_create_a_lesson()
    {
        $this->loginAdmin();
        //admin/id/lessons
        $series = factory(Series::class)->create();

        //data
        $lesson = [
            "title" => 'new lesson',
            'episode_number' => 1,
            'video_id' => 1234567890
        ];
        $this->post("/admin/{$series->id}/lessons", $lesson)
            ->assertSessionHasErrors('description');
    }

    /**
     * test an episode number is required to create a lesson
     *
     * @return void
     */
    public function test_an_episode_number_is_required_to_create_a_lesson()
    {
        $this->loginAdmin();
        //admin/id/lessons
        $series = factory(Series::class)->create();

        //data
        $lesson = [
            "title" => 'new lesson',
            'description' => 'new lesson description',
            'video_id' => 1234567890
        ];
        $this->post("/admin/{$series->id}/lessons", $lesson)
            ->assertSessionHasErrors('episode_number');
    }

    /**
     * test a video id is required to create a lesson
     *
     * @return void
     */
    public function test_a_video_id_is_required_to_create_a_lesson()
    {
        $this->loginAdmin();
        //admin/id/lessons
        $series = factory(Series::class)->create();

        //data
        $lesson = [
            "title" => 'new lesson',
            'description' => 'new lesson description',
            'episode_number' => 1,
        ];
        $this->post("/admin/{$series->id}/lessons", $lesson)
            ->assertSessionHasErrors('video_id');
    }
}
