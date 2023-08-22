<?php

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OrderTest extends KernelTestCase
{
    public function testOrderAttributes()
    {
        $order = new Order();
        $order->setNumber('ORD123');
        $order->setTotalPrice(100.0);

        $this->assertEquals('ORD123', $order->getNumber());
        $this->assertEquals(100.0, $order->getTotalPrice());
    }
}