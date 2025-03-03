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
}
