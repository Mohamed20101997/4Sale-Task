<?php

namespace App\Payment;

class PaymentContext
{
    private $strategy;

    public function __construct(PaymentStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function executeStrategy($amount)
    {
        return $this->strategy->calculateTotal($amount);
    }
}

