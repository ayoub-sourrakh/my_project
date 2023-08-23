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
            (new Product())->setPrice(10.0),
            (new Product())->setPrice(20.0),
        ];

        $totalHT = $calculator->getTotalHT($products);

        $this->assertEquals(30.0, $totalHT);
    }

    public function testGetTotalTTC()
    {
        $calculator = new Calculator();

        $products = [
            (new Product())->setPrice(10.0),
            (new Product())->setPrice(20.0),
        ];

        $tva = 20.0;

        $totalTTC = $calculator->getTotalTTC($products, $tva);

        $expectedTotalTTC = (10.0 + 20.0) * (1 + ($tva / 100));

        $this->assertEquals($expectedTotalTTC, $totalTTC);
    }
}
