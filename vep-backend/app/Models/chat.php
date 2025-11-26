<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class chat extends Model
{
    protected $fillable = [
        'event_id',
        'user_id',
        'message',
        'is_question'
    ];
    public function event() {
        return $this-> belongsTo(Event::class);
    }
    public function user() {
        return $this-> belongsTo(user::class);
    }
}
