<?php

namespace Tests\Unit;

use App\Services\QuotationCalculatorService;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class QuotationCalculatorServiceTest extends TestCase
{
    #[Test]
    public function testCalculateReturnsCorrectTotalForGivenAgesAndTripLength(): void {
        // Worked Example: Total = (3 * 0.6 * 30) + (3 * 0.7 * 30) = 117.00
        $ages = [18, 31];
        $tripLengthInDays = 30;
        $this->assertEquals(117, QuotationCalculatorService::from($ages, $tripLengthInDays)->calculate());
    }
}
