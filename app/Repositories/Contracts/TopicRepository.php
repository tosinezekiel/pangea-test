<?php
namespace App\Repositories\Contracts;

use App\Models\Topic;

interface TopicRepository{
    public function saveTopic(array $data);

    public function publishMessageToSubscribers(Topic $topic, array $data);
}