<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScheduleInterview extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'schedule_interviews';

    protected $fillable = [
        'title',
        'company_id',
        'job_id',
        'start_date',
        'end_date',
        'link',
        'type',
        'description',
        'event_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'interviews', 'schedule_interview_id', 'user_id')
            ->withTimestamps();
    }

    public function interviews()
    {
        return $this->hasMany(Interview::class, 'schedule_interview_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
