<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Topic;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateTopicTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_validation_error_occur_if_title_is_not_specified()
    {
        $topic = Topic::factory()->make(['title' => null]);
        $response = $this->withExceptionHandling()->postJson('/api/topics', $topic->toArray());

        $response->assertStatus(422);
    }

    public function test_topic_can_be_created_if_title_is_specified()
    {
        $topic = Topic::factory()->make();

        $response = $this->withExceptionHandling()->postJson('/api/topics', $topic->toArray());

        $response->assertStatus(201);
    }

    public function test_topic_persisted_to_database()
    {
        $topic = Topic::factory()->create();

        $this->assertJson($topic);

        $this->assertDatabaseHas('topics', [
            'title' =>  $topic->title
        ]);
    }
}
