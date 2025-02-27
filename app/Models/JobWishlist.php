<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobWishlist extends Model
{
    use HasFactory;

    protected $tables = 'wishlists';

    protected $fillable = ['user_id', 'job_id', 'is_save'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
