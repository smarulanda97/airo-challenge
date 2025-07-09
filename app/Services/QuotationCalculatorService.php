<?php

namespace App\Services;

use App\Enums\AgeLoadTax;

/**
 * QuotationCalculatorService
 *
 * Calculates the total amount of a quotation. Creating a separate
 * class allows to test independently this critical part of any system.
 */
class QuotationCalculatorService
{
    /**
     * A fixed amount that is applied to quotation per age
     */
    const int FIXED_QUOTATION_RATE_AMOUNT_IN_CENTS = 300;

    /**
     * @var array<int> The list of ages to calculate the quotation
     */
    private array $ages;

    /**
     * @var int The duration of the trip represented in days
     */
    private int $tripLengthInDays;

    /**
     * @param array $ages
     * @param int $tripLengthInDays
     * @return self
     */
    public static function from(array $ages, int $tripLengthInDays): self
    {
        $instance = new self();
        $instance->ages = $ages;
        $instance->tripLengthInDays = $tripLengthInDays;
        return $instance;
    }

    /**
     * Calculate the total of the quotation
     *
     * @return int
     */
    public function calculate(): int
    {
        $total = 0;
        $fixedRate = self::FIXED_QUOTATION_RATE_AMOUNT_IN_CENTS;

        foreach ($this->ages as $age) {
            $ageTax = AgeLoadTax::fromAge($age)->getTaxAmountInCents();
            $total += ($fixedRate * $ageTax * $this->tripLengthInDays) / 100;
        }

        return intdiv($total, 100);
    }
}
