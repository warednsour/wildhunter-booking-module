<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guide extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'experience_years', 'is_active'];

    public function bookings()
    {
        return $this->hasMany(HuntingBooking::class);
    }
}
