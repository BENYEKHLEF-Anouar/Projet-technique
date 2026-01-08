<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\CalculatorService;

class CalculatorTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_calculate_sum_of_two_numbers()
    {
        $calculatrice = new CalculatorService();
        $resultat = $calculatrice->sum(5, 3);
        $this->assertEquals(8, $resultat);
    }
}

// php artisan test tests/Unit/CalculatorTest.php
// php artisan test
// php artisan test --testsuite=Unit


