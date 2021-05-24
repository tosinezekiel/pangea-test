<?php
namespace App\Repositories\Contracts;

use App\Models\Topic;

interface SubscriberRepository{
    public function subscribeToTopic(Topic $topic, array $validated);
}