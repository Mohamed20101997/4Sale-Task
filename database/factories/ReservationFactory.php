<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\Table;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition()
    {
        // Ensure related models exist
        $table = Table::factory()->create();
        $customer = Customer::factory()->create();

        // Define a start and end time for the reservation
        $fromTime = $this->faker->dateTimeBetween('now', '+1 week');
        $toTime = (clone $fromTime)->modify('+2 hours');

        return [
            'table_id' => $table->id,
            'customer_id' => $customer->id,
            'from_time' => $fromTime->format('Y-m-d H:i:s'),
            'to_time' => $toTime->format('Y-m-d H:i:s'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
