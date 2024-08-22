<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReservationTest extends TestCase
{

    use RefreshDatabase;

    // public function test_check_availability_and_add_to_waiting_list()
    // {
    //     // Create tables and reservations to ensure none are available
    //     $table = Table::factory()->create(['capacity' => 20]);
    //     $customer = Customer::factory()->create();

    //     Reservation::factory()->create([
    //         'table_id' => $table->id,
    //         'customer_id' => $customer->id,
    //         'from_time' => now()->subHour()->format('Y-m-d H:i:s'),
    //         'to_time' => now()->addHour()->format('Y-m-d H:i:s'),
    //     ]);

    //     $response = $this->postJson('/api/reservations/check-availability', [
    //         'capacity' => 4,
    //         'from_time' => now()->format('Y-m-d H:i:s'),
    //         'to_time' => now()->addHours(2)->format('Y-m-d H:i:s'),
    //         'customer_id' => $customer->id,
    //     ]);

    //     $response->assertStatus(200)
    //              ->assertJson(['message' => 'No tables available. Added to waiting list.']);
    // }

    public function test_reserve_table_successfully()
    {
        $table = Table::factory()->create(['capacity' => 4]);
        $customer = Customer::factory()->create();

        $response = $this->postJson('/api/reservations/reserve-table', [
            'table_id' => $table->id,
            'customer_id' => $customer->id,
            'from_time' => now()->addHours(2)->format('Y-m-d H:i:s'),
            'to_time' => now()->addHours(3)->format('Y-m-d H:i:s'),
        ]);

        $response->assertStatus(201)->assertJsonStructure(['id', 'table_id', 'customer_id', 'from_time', 'to_time']);
    }

}
