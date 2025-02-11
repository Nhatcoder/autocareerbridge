<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvSkill extends Model
{
    use HasFactory;

    protected $table = 'cv_skill';

    protected $fillable = [
        'cv_id',
        'name',
    ];
}
