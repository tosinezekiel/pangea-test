<?php

namespace App\Jobs;

use App\Enums\Status;
use App\Models\Notification;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Http;

class ProcessPublishment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $notification = Notification::where('status', Status::PENDING)->where('attempt', '<=', 3)->first();
            $data = [];
            $data['message'] = json_decode($notification->data);
            $data['time'] = Carbon::now();

            $response = Http::post($notification->subscriber->url, $data);
            if(!$response->successful()){
                $notification->update([
                    "attempt" => $notification->attempt -= 1,
                    "status" => Status::PENDING
                ]);

                return false;
            }
            $notification->update([
                "status" => Status::COMPLETED,
                "attempt" => 0
            ]);
        }catch(Exception $e){
            \Log::info($e->getMessage());
        }
    }
}
