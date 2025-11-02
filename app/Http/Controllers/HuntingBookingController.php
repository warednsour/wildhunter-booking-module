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

        // Проверка: гид не занят на выбранную дату
        $exists = HuntingBooking::where('guide_id', $validated['guide_id'])
            ->where('date', $validated['date'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Этот гид уже забронирован на выбранную дату.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($validated['participants_count'] > 10) {
            return response()->json([
                'message' => 'Максимум 10 участников на тур.'
            ], Response::HTTP_BAD_REQUEST);
        }

        $booking = HuntingBooking::create($validated);

        return new HuntingBookingResource($booking);
    }
}
