<?php

namespace App\Service;

use App\Entity\Product;

class Calculator
{
    public function getTotalHT(array $products): float
    {
        $totalHT = 0.0;

        foreach ($products as $product) {
            $totalHT += $product->getPrice();
        }

        return $totalHT;
    }

    public function getTotalTTC(array $products, float $tva): float
    {
        $totalTTC = 0.0;

        foreach ($products as $product) {
            $totalTTC += $product->getPrice() * (1 + ($tva / 100));
        }

        return $totalTTC;
    }
}
