<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'image',
        'date_publication',
    ];

    protected $casts = [
        'date_publication' => 'date',
    ];
}
