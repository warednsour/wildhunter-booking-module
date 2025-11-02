<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHuntingBookingRequest;
use App\Http\Resources\HuntingBookingResource;
use App\Models\HuntingBooking;
use Illuminate\Http\Response;

class HuntingBookingController extends Controller
{
    public function store(StoreHuntingBookingRequest $request)
    {
        $validated = $request->validated();
    
        // Check double booking
        $exists = HuntingBooking::where('guide_id', $validated['guide_id'])
            ->where('date', $validated['date'])
            ->exists();
    
        if ($exists) {
            return response()->json([
                'message' => 'Этот гид уже забронирован на выбранную дату.'
            ], 422);
        }
    
        // Create new booking
        $booking = HuntingBooking::create($validated);
    
        // Return the created booking as JSON
        return response()->json($booking, 201);
    }
}
