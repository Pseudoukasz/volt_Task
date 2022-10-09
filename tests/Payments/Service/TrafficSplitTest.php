<?php

namespace App\Tests\Payments\Service;

use App\Payments\Model\Payment;
use App\Payments\Service\TrafficSplit;
use PHPUnit\Framework\TestCase;

class TrafficSplitTest extends TestCase
{
    public function gatewayListProvider(): array
    {
        return [
            [
                [
                    'Gateway1' => 40,
                    'Gateway2' => 20,
                    'Gateway3' => 30,
                ],
                ['expected' => 'Gateway2']
            ],
            [
                [
                    'Gateway1' => 40,
                    'Gateway2' => 20,
                    'Gateway3' => 20,
                ],
                ['expected' => 'Gateway2']
            ],
        ];
    }

    /**
     * @dataProvider gatewayListProvider
     */
    public function testHandlePayment($data, $expected)
    {
        $trafficSplitter = new TrafficSplit($data);
        $payment = new Payment();
        $paymentGateway = $trafficSplitter->handlePayment($payment);
        $expectedGateway = 'App\Payments\Gateway\\' . $expected['expected'];

        $this->assertInstanceOf($expectedGateway, $paymentGateway);
    }
}
