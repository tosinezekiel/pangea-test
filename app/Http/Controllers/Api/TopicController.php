<?php

namespace App\Http\Controllers\Api;

use App\Models\Topic;
use App\Traits\Reportable;
use Illuminate\Http\Request;
use App\Http\Requests\TopicRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\TopicRepository;


class TopicController extends Controller
{
    use Reportable;

    public $topic;

    public function __construct(TopicRepository $topic) 
    {
        $this->topic = $topic;
    }

    public function store(TopicRequest $request)
    {
        $validated = $request->validated();
        try {
            $topic = $this->topic->saveTopic($validated);
            return  $this->successResponse('Topic created successfully.', $topic, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function publish(Topic $topic)
    {
        $data = request()->all();
        try {
            $data = $this->topic->publishMessageToSubscribers($topic, $data);
            return  $this->successResponse('Data published successfully.', $data, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
