<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Table;
use App\Models\WaitingList;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    public function checkAvailability(Request $request)
    {

        $capacity = $request->input('capacity');
        $fromTime = $request->input('from_time');
        $toTime = $request->input('to_time');

        $availableTables = Table::whereDoesntHave('reservations', function ($query) use ($fromTime, $toTime) {
            $query->where(function ($query) use ($fromTime, $toTime) {
                $query->whereBetween('from_time', [$fromTime, $toTime])
                    ->orWhereBetween('to_time', [$fromTime, $toTime]);
            });
        })->where('capacity', '>=', $capacity)->get();


        if ($availableTables->isEmpty()) {
            // Add customer to waiting list
            $waitingList = WaitingList::create([
                'customer_id' => $request->input('customer_id'),
                'party_size' => $capacity,
                'requested_time' => $fromTime,
            ]);

            return response()->json(['message' => 'No tables available. Added to waiting list.'], 200);
        }

        return response()->json(['table'=>$availableTables] , 200);
    }


    public function reserveTable(Request $request)
    {
        $reservation = Reservation::create([
            'table_id' => $request->input('table_id'),
            'customer_id' => $request->input('customer_id'),
            'from_time' => $request->input('from_time'),
            'to_time' => $request->input('to_time'),
        ]);

        return response()->json($reservation, 201);
    }

}
