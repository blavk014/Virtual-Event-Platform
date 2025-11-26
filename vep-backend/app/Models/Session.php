<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'event_id',
        'title',
        'description',
        'speaker',
        'start_at',
        'end_at',
        'video_url',
        'location',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
