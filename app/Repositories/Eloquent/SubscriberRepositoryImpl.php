<?php
namespace App\Repositories\Eloquent;

use App\Models\Subscriber;
use App\Models\Topic;
use App\Repositories\Contracts\SubscriberRepository;

class SubscriberRepositoryImpl implements SubscriberRepository{

    public function subscribeToTopic(object $topic, array $data)
    {
        $subscriber =  Subscriber::create($data);
        $topic->subscribers()->attach($subscriber->id);
        $payload = $this->setPayload($topic, $subscriber);
        return $payload;
    }

    public function setPayload(Topic $topic, Subscriber $subscriber) : array{
        return [
            'url' => $subscriber->url,
            'topic' => $topic->title,
            'topic_reference' => $topic->reference
        ];
    }

}