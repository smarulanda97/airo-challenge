<?php

namespace Tests\Fixtures;

class ValidQuotationFixture
{
    /**
     * New
     *
     * Returns an array with valid information to generate a quotation
     */
    public static function new(): array
    {
        $ages = [
            fake()->numberBetween(18, 100),
            fake()->numberBetween(18, 31),
            fake()->numberBetween(31, 50),
        ];
        $startDate = fake()->dateTimeBetween('now', '+2 months');

        return [
            'age' => implode(',', $ages),
            'currency_id' => fake()->randomElement(['EUR', 'GBP', 'USD']),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => (clone $startDate)->modify('+9 days')->format('Y-m-d'),
        ];
    }
}
