<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'status',
        'last_update',
        'tracking'
    ];

    protected $casts = [
        'last_update' => 'array',
        'tracking' => 'array'
    ];
}
