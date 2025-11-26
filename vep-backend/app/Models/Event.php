<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organizer_id',
        'title',
        'slug',
        'description',
        'venue',
        'is_virtual',
        'start_at',
        'end_at',
        'capacity',
        'thumbnail',
        'status',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
    public function chats() {
        return $this->hasMany(chat::class);
    }

}
