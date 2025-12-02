<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Odp extends Model
{
    protected $fillable = [
        'name',
        'code',
        'location_name',
        'latitude',
        'longitude',
        'capacity',
        'available_ports',
        'status',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'capacity' => 'integer',
        'available_ports' => 'integer',
    ];
}
