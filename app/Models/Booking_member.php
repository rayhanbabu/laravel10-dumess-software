<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking_member extends Model
{
    protected $fillable = [
        'phone',
        'otp',
        'hall_id',
    ];
    use HasFactory;
}
