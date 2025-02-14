<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CvSkill extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cv_skill';

    protected $fillable = [
        'cv_id',
        'name',
    ];
}
