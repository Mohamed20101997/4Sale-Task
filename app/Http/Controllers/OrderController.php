<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Payment\PaymentContext;
use Illuminate\Http\Request;
use App\Payment\ServiceOnlyStrategy;
use App\Payment\TaxAndServiceStrategy;

class OrderController extends Controller
{
    public function order(Request $request)
    {
        $order = Order::create([
            'table_id' => $request->input('table_id'),
            'reservation_id' => $request->input('reservation_id'),
            'customer_id' => $request->input('customer_id'),
            'user_id' => $request->input('user_id'),
            'total' => 0,
            'paid' => 0,
            'date' => now(),
        ]);

        $total = 0;
        foreach ($request->input('meals') as $meal) {
            $mealModel = Meal::find($meal['meal_id']);
            $amountToPay = $mealModel->price - ($mealModel->price * $mealModel->discount / 100);

            $orderDetail = OrderDetail::create([
                'order_id' => $order->id,
                'meal_id' => $mealModel->id,
                'amount_to_pay' => $amountToPay,
            ]);

            $total += $amountToPay;
        }

        $order->total = $total;
        $order->save();

        return response()->json($order, 201);
    }

    public function pay(Request $request, $id)
    {
        $order = Order::find($id);

        $paymentType = $request->input('payment_type');
        $context = null;

        if ($paymentType == 'tax_and_services') {
            $context = new PaymentContext(new TaxAndServiceStrategy);
        } elseif ($paymentType == 'service_only') {
            $context = new PaymentContext(new ServiceOnlyStrategy);
        }

        if ($context) {
            $order->paid = $context->executeStrategy($order->total);
            $order->save();
        }

        return response()->json($order);
    }




}
