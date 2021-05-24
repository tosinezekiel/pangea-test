<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $hidden = ['id', 'created_at', 'updated_at'];

    protected $fillable = ['title', 'reference'];

    public function setReferenceAttribute(string $value) : void
    {
        $this->attributes['reference'] = reference_generator($value, 6);
    }

    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class, 'subscriber_topic');
    }
}
