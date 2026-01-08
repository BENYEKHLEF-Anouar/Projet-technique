<?php

namespace App\Services;

class CalculatorService
{

    public function sum(int $a, int $b) : int
    {
        return $a + $b;
    }
}