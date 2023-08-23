<?php

namespace App\Tests\Service;

use App\Entity\Product;
use App\Service\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testGetTotalHT()
    {
        $calculator = new Calculator();

        $products = [
            [
                'product' => (new Product())->setPrice(10.0),
                'quantity' => 2,
            ],
            [
                'product' => (new Product())->setPrice(20.0),
                'quantity' => 3,
            ],
        ];

        $totalHT = $calculator->getTotalHT($products);

        $expectedTotalHT = (10.0 * 2) + (20.0 * 3);

        $this->assertEquals($expectedTotalHT, $totalHT);
    }

    public function testGetTotalTTC()
    {
        $calculator = new Calculator();

        $products = [
            [
                'product' => (new Product())->setPrice(10.0),
                'quantity' => 2,
            ],
            [
                'product' => (new Product())->setPrice(20.0),
                'quantity' => 3,
            ],
        ];

        $tva = 20.0;

        $totalTTC = $calculator->getTotalTTC($products, $tva);

        $expectedTotalTTC = ((10.0 * 2) * (1 + ($tva / 100))) + ((20.0 * 3) * (1 + ($tva / 100)));

        $this->assertEquals($expectedTotalTTC, $totalTTC);
    }
}
