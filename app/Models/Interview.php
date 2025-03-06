<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $table = 'interviews';

    protected $fillable = [
        'user_id',
        'schedule_interview_id',
        'status',
    ];

    public function scheduleInterview()
    {
        return $this->belongsTo(ScheduleInterview::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
