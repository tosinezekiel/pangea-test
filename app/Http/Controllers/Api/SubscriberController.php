<?php

namespace App\Http\Controllers\Api;

use App\Models\Topic;
use App\Traits\Reportable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriberRequest;
use App\Repositories\Contracts\SubscriberRepository;

class SubscriberController extends Controller
{
    use Reportable;

    public $subscriber;

    public function __construct(SubscriberRepository $subscriber) 
    {
        $this->subscriber = $subscriber;
    }

    public function subscribe(SubscriberRequest $request, Topic $topic)
    {
        $validated = $request->validated();
        try {
            $subscription = $this->subscriber->subscribeToTopic($topic, $validated);
            return  $this->successResponse("Successfully subscribed to {$topic->title}.", $subscription, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
