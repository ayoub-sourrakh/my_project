<?php

use App\Entity\Order;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OrderTest extends KernelTestCase
{
    public function testOrderAttributes()
    {
        $order = new Order();
        $order->setNumber('ORD123');
        $order->setTotalPrice(100.0);

        $user = new User();
        $user->setLastName('Doe');
        $user->setFirstName('John');
        $user->setEmail('john@example.com');
        $user->setPassword('securepassword');

        $order->setUserId($user);

        $this->assertEquals('ORD123', $order->getNumber());
        $this->assertEquals(100.0, $order->getTotalPrice());
        $this->assertSame($user, $order->getUserId());
    }
}