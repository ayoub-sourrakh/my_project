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

        $this->assertEquals(80, $totalHT);
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

        $this->assertEquals(96, $totalTTC);
    }
}
