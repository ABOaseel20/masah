<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
        'client_id',
        'hall_id',
        'event_date',
        'total_price',
        'paid_amount',
        'remaining_amount',
        'status'
    ];

    protected $casts = [
        'event_date' => 'date',
        'total_price' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
    ];

    // علاقة الحجز بالعميل
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // علاقة الحجز بالقاعة
    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }
    public function payments()
{
    return $this->hasMany(Payment::class);
}
public function getTotalPaidAttribute()
{
    return $this->payments()->sum('amount');
}

public function getRemainingAttribute()
{
    return $this->total_price - $this->total_paid;
}
}