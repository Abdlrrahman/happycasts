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
     * A basic test example.
     *
     * @return void
     */
    public function test_a_user_can_create_lessons()
    {
        $this->loginAdmin();
        $this->withoutExceptionHandling();

        //admin/3/lessons
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
}
