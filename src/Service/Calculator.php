<?php

namespace App\Service;

class Calculator
{
    public function getTotalHT(array $productsWithQuantities): float
    {
        $totalHT = 0.0;

        foreach ($productsWithQuantities as $productWithQuantity) {
            $product = $productWithQuantity['product'];
            $quantity = $productWithQuantity['quantity'];
            $totalHT += $product->getPrice() * $quantity;
        }

        return $totalHT;
    }

    public function getTotalTTC(array $productsWithQuantities, float $tva): float
    {
        $totalHT = $this->getTotalHT($productsWithQuantities);
        $totalTTC = $totalHT * (1 + ($tva / 100));

        return $totalTTC;
    }
}
