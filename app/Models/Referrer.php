<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Referrer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'referrers';

    protected $fillable = [
        'cv_id',
        'name',
        'name',
        'company_name',
        'position',
        'phone',
    ];
}
