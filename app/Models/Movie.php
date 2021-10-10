<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use HasFactory, SoftDeletes;

    protected $date = ['deleted_at'];
    protected $casts = [
        'year' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
//    public function getDateAttribute(){
//        return
//    }
//    protected $attributes = [
//        'poster' => null,
//        'synopsys' => null,
//    ];
}

