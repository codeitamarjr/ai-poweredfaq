<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatInteraction extends Model
{
    protected $fillable = [
        'question',
        'answer',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
