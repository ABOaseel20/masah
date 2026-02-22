<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    protected $fillable = [
        'name',
        'capacity',
        'price',
        'status'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}