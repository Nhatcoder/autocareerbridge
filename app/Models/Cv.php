<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cv extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'user_id',
        'slug',
        'email',
        'phone',
        'position',
        'avatar',
        'date_birth',
        'sex',
        'url',
        'introduce',
    ];

    protected $with = [
        'educations',
        'experiences',
        'achievements',
    ];

    public function educations(){
        return $this->hasMany(Education::class, );
    }

    public function experiences(){
        return $this->hasMany(Experience::class);
    }

    public function achievements(){
        return $this->hasMany(Achievement::class);
    }
}
