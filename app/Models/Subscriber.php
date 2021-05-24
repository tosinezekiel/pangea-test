<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = ['url'];

    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'subscriber_topic');
    }
}
