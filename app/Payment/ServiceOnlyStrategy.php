<?php

namespace App\Payment;

use App\Payment\PaymentStrategy;

class ServiceOnlyStrategy implements PaymentStrategy
{
    public function calculateTotal($amount)
    {
        $serviceCharge = 0.15 * $amount;
        return $amount + $serviceCharge;
    }

}
