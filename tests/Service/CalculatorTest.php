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

        $products[0]->setQuantity(2);
        $products[1]->setQuantity(3);


        $totalHT = $calculator->getTotalHT($products);

        $expectedTotalHT = (10.0 * 2) + (20.0 * 3);

        $this->assertEquals($expectedTotalHT, $totalHT);
    }

    public function testGetTotalTTC()
    {
        $calculator = new Calculator();

        $products = [
            (new Product())->setPrice(10.0),
            (new Product())->setPrice(20.0),
        ];

        $products[0]->setQuantity(2);
        $products[1]->setQuantity(3);

        $tva = 20.0;

        $totalTTC = $calculator->getTotalTTC($products, $tva);

        $expectedTotalTTC = ($products[0]->getPrice() * $products[0]->getQuantity() * (1 + ($tva / 100))) + ($products[1]->getPrice() * $products[1]->getQuantity() * (1 + ($tva / 100)));

        $this->assertEquals($expectedTotalTTC, $totalTTC);
    }
}
