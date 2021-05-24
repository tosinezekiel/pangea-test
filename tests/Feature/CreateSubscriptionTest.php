<?php

namespace Tests\Feature;

use App\Models\Subscriber;
use Tests\TestCase;
use App\Models\Topic;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateSubscriptionTest extends TestCase
{
    use DatabaseMigrations, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_error_occur_if_topic_reference_does_not_exist_in_database()
    {
        $topic = Topic::factory()->create();
        $subscriber = Subscriber::factory()->make();
        $reference = 'topic'.$this->faker->numberBetween(1,15);
        
        $response = $this->withExceptionHandling()->postJson("/api/subscribe/{$reference}", $subscriber->toArray());

        $response->assertStatus(404);
    }

    public function test_validation_error_occur_if_url_is_not_specified()
    {
        $topic = Topic::factory()->create();
        $subscriber = Subscriber::factory()->make(['url' => null]);
        $response = $this->withExceptionHandling()->postJson("/api/subscribe/{$topic->reference}", $subscriber->toArray());

        $response->assertStatus(422);
    }

    public function test_subscription_can_be_created_if_url_is_specified()
    {
        $topic = Topic::factory()->create();
        $subscriber = Subscriber::factory()->make();

        $response = $this->withExceptionHandling()->postJson("/api/subscribe/{$topic->reference}", $subscriber->toArray());

        $this->assertTrue($response['data']['topic'] === $topic->title);

        $response->assertJsonFragment([
            "url" => $response['data']['url'], 
            "topic" => $topic->title, 
            'topic_reference' => $topic->reference
        ])->assertStatus(200);
    }

    public function test_subscription_belong_to_topic()
    {
        $topic = Topic::factory()->create();
        $subscriber = Subscriber::factory()->create();

        $topic->subscribers()->sync($subscriber->id);

        $this->assertDatabaseHas('subscriber_topic', [
            'topic_id' => $topic->id,
            'subscriber_id' => $subscriber->id
        ]);
    }

    public function test_message_is_persisted_to_database()
    {
        $topic = Topic::factory()->create();

        $subscriber = Subscriber::factory()->create();

        $topic->subscribers()->sync($subscriber->id);

        $data = [
            "message" => "hello"
        ];

        $response = $this->withExceptionHandling()->postJson("/api/publish/{$topic->reference}", $data);

        $this->assertDatabaseHas('notifications', [
            'topic_id' => $topic->id,
            'subscriber_id' => $subscriber->id,
            'data' => json_encode($data)
        ]);

        $response->assertJsonFragment([
            "topic" => $topic->title,
            "data" => $data
        ])
        ->assertStatus(200);
    }

}
