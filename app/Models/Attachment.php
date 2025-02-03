<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'attachments';
    protected $guarded = [];

    public function chatMessages()
    {
        return $this->belongsToMany(ChatMessage::class, 'attachments', 'chat_id', 'id');
    }
}
