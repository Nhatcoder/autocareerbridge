<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cv extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'upload',
        'title',
        'font',
        'color',
        'username',
        'position',
        'template',
        'user_id',
        'email',
        'phone',
        'address',
        'avatar',
        'birthdate',
        'url',
        'introduce',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function educations()
    {
        return $this->hasMany(Education::class,);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function referrers()
    {
        return $this->hasMany(Referrer::class);
    }

    public function cv_skill()
    {
        return $this->hasMany(CvSkill::class);
    }
}
