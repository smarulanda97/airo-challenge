<?php

namespace App\Enums;

/**
 * AgeLoadTax
 *
 * Fixed rate applied according to the age.
 * Rates are represented as base 100 integers. i.e = 60 => 0.6
 */
enum AgeLoadTax: int
{
    case RATE_AGE_18_30 = 60;  // 0.6
    case RATE_AGE_31_40 = 70;  // 0.7
    case RATE_AGE_41_50 = 80;  // 0.8
    case RATE_AGE_51_60 = 90;  // 0.9
    case RATE_AGE_61_70 = 100; // 1

    /**
     * Get the correct fixed rate based on an age
     */
    public static function fromAge(int $age): ?self
    {
        return match (true) {
            $age >= 18 && $age <= 30 => self::RATE_AGE_18_30,
            $age >= 31 && $age <= 40 => self::RATE_AGE_31_40,
            $age >= 41 && $age <= 50 => self::RATE_AGE_41_50,
            $age >= 51 && $age <= 60 => self::RATE_AGE_51_60,
            default => self::RATE_AGE_61_70
        };
    }

    /**
     * Get the associated rate related to the case age
     */
    public function getTaxAmountInCents(): int
    {
        return $this->value;
    }
}
