<?php

namespace App\Payment;


interface PaymentStrategy
{
    public function calculateTotal($amount);
}
