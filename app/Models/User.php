<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_name',
        'name',
        'email',
        'phone',
        'avatar_path',
        'password',
        'google_id',
        'facebook_id',
        'role',
        'active',
        'email_verified_at',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function hiring()
    {
        return $this->hasOne(Hiring::class);
    }

    public function academicAffair()
    {
        return $this->hasOne(AcademicAffair::class);
    }

    public function university()
    {
        return $this->hasOne(University::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'user_id', 'id');
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class, 'from_id', 'id');
    }

    public function isAdmin()
    {
        return $this->role === ROLE_ADMIN;
    }

    public function userJob()
    {
        return $this->hasMany(UserJob::class, 'user_id', 'id');
    }
}
