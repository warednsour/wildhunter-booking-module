<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Guide;
use App\Models\HuntingBooking;

class HuntingBookingTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

        /** @test */
        public function it_prevents_double_booking_for_the_same_guide_and_date()
        {
            // Arrange: create a guide and an existing booking for a specific date
            $guide = Guide::factory()->create();
            HuntingBooking::factory()->create([
                'guide_id' => $guide->id,
                'date' => '2025-11-10',
            ]);
    
            // Act: try to create another booking for the same guide and date
            $response = $this->postJson('/api/bookings', [
                'tour_name' => 'Wild Elk Hunt',
                'hunter_name' => 'John Doe',
                'guide_id' => $guide->id,
                'date' => '2025-11-10',
                'participants_count' => 5,
            ]);
    
            // Assert: should fail with 422 Unprocessable Entity
            $response->assertStatus(422)
                     ->assertJson([
                         'message' => 'Этот гид уже забронирован на выбранную дату.'
                     ]);
        }
    
        /** @test */
        public function it_allows_booking_when_guide_is_free_and_participants_are_valid()
        {
            $guide = Guide::factory()->create();
    
            $response = $this->postJson('/api/bookings', [
                'tour_name' => 'Bear Hunt',
                'hunter_name' => 'Alex Smith',
                'guide_id' => $guide->id,
                'date' => '2025-11-20',
                'participants_count' => 4,
            ]);
    
            $response->assertStatus(201)
                     ->assertJsonStructure([
                         'id',
                         'tour_name',
                         'hunter_name',
                         'date',
                         'participants_count'
                     ]);
        }
    
        /** @test */
        public function it_rejects_when_participants_exceed_limit()
        {
            $guide = Guide::factory()->create();
    
            $response = $this->postJson('/api/bookings', [
                'tour_name' => 'Massive Hunt',
                'hunter_name' => 'Alex Smith',
                'guide_id' => $guide->id,
                'date' => '2025-11-22',
                'participants_count' => 15,
            ]);
    
            $response->assertStatus(422)
                     ->assertJson([
                         'message' => 'Максимум 10 участников на тур.'
                     ]);
        }
    
}
