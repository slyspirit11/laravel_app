<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Movie extends Model
{
    use HasFactory, SoftDeletes;

    protected $date = ['deleted_at'];
    protected $guarded = ['id'];
    protected $casts = [
        'year' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getMovieAgeAttribute()
    {
        return date('Y') - $this->year;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::updating(function ($movie) {
            $canUpdate = Auth::user()->is_admin || Auth::id() === $movie->user_id;
            if (!$canUpdate) {
                Log::info('This user cannot update model');
            }
            return $canUpdate;
        });
    }
}

