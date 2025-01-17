<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Experience extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name_company',
        'cv_id',
        'name_project',
        'position',
        'date',
        'description',
        'url',
    ];
}
