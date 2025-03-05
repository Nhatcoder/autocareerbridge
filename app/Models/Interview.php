<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interview extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'interviews';
    protected $fillable = ['schedule_interview_id', 'user_id', 'status'];

    public function scheduleInterview()
    {
        return $this->belongsTo(ScheduleInterview::class, 'schedule_interview_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
