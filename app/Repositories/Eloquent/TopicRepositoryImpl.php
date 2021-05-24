<?php
namespace App\Repositories\Eloquent;

use App\Models\Topic;
use App\Models\Subscriber;
use App\Models\Notification;
use App\Jobs\ProcessPublishment;
use App\Repositories\Contracts\TopicRepository;

class TopicRepositoryImpl implements TopicRepository{
    public function saveTopic($data)
    {
        $data['reference'] = 'topic';
        $topic = Topic::create($data);
        return $topic;
    }

    public function publishMessageToSubscribers(Topic $topic, array $data)
    {
        $subscribers = $topic->subscribers;
        foreach($subscribers as $subscriber){
            Notification::create([
                'topic_id' => $topic->id,
                'subscriber_id' => $subscriber->id,
                'data' => json_encode($data)
            ]);
        }
        $payload = $this->setPayload($topic, $data);
        return $payload;
    }

    public function setPayload(Topic $topic, array $data) : array{
        return [
            "topic" => $topic->title,
            "data" => $data
        ];
    }
}