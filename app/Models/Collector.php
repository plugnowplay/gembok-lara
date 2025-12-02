<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collector extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'commission_rate',
        'status',
        'password',
    ];

    protected $casts = [
        'commission_rate' => 'float',
    ];

    protected $hidden = [
        'password',
    ];
}
