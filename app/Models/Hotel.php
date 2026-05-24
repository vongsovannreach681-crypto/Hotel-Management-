<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'room_count',
        'price_per_night',
        'description',
        'available',
        'image',
        'status',
    ];

    protected $casts = [
        'room_count' => 'integer',
        'price_per_night' => 'decimal:2',
        'available' => 'boolean',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
