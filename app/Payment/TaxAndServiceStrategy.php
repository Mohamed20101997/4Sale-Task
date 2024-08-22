<?php

namespace App\Payment;

use App\Payment\PaymentStrategy;

class TaxAndServiceStrategy implements PaymentStrategy
{
    public function calculateTotal($amount)
    {
        $tax = 0.14 * $amount;
        $serviceCharge = 0.2 * $amount;
        return $amount + $tax + $serviceCharge;
    }
}
