<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatMessage extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'chat_messages';
    protected $guarded = [];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'chat_id', 'id');
    }
}
