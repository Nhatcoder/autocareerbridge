<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referrer extends Model
{
    use HasFactory;

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
