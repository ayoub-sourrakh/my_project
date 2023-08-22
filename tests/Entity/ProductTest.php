<?php

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductTest extends KernelTestCase
{
    public function testProductAttributes()
    {
        $product = new Product();
        $product->setName('Cool Product');
        $product->setPrice(19.99);

        $this->assertEquals('Cool Product', $product->getName());
        $this->assertEquals(19.99, $product->getPrice());
    }
}