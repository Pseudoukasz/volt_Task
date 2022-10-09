<?php

namespace App\Payments\Service;

use App\Payments\Gateway\Gateway2;
use App\Payments\Gateway\Gateway3;
use App\Payments\Gateway\Gateway1;
use App\Payments\Model\Payment;

class TrafficSplit
{
    private array $paymentGateways;

    public function __construct(array $paymentGateways)
    {
        $this->paymentGateways = $paymentGateways;
    }

    public function handlePayment(Payment $payment): object
    {
        asort($this->paymentGateways);
        $keyName = 'App\Payments\Gateway\\' . key($this->paymentGateways);
        $gateway = new $keyName();
        $gateway->payment = $payment;

        return $gateway;
    }
}
