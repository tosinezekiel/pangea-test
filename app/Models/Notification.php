<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function subscriber(){
        return $this->belongsTo(Subscriber::class, 'subscriber_id');
    }

    public function topic(){
        return $this->belongsTo(Topic::class, 'topic_id');
    }
}
