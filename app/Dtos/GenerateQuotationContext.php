<?php

namespace App\Dtos;

use Illuminate\Support\Carbon;

/**
 * GenerateQuotationContext
 *
 * It allows to transfer data from the http (controller) layer
 * to the service layer, without depending on the exact data structure
 * received in the request payload
 */
readonly class GenerateQuotationContext
{
    /**
     * @param  array<int>  $ages
     */
    public function __construct(
        private array $ages,
        private string $currencyCode,
        private Carbon $startDate,
        private Carbon $endDate
    ) {}

    /**
     * Get the ages
     *
     * @return array<int>
     */
    public function getAges(): array
    {
        return $this->ages;
    }

    /**
     * Get the currency code
     */
    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    /**
     * Get the start date
     */
    public function getStartDate(): Carbon
    {
        return $this->startDate;
    }

    /**
     * Get the end date
     */
    public function getEndDate(): Carbon
    {
        return $this->endDate;
    }

    /**
     * Return the amount of days between the start and end dates
     */
    public function getDaysBetween(): int
    {
        return $this->startDate->diffInDays($this->endDate);
    }

    /**
     * Create the quotation context from an array
     *
     * @param array{
     *     age: array<int>,
     *     currency_id: string,
     *     start_date: Carbon,
     *     end_date: Carbon,
     * } $array
     */
    public static function fromArray(array $array): self
    {
        // For the sake of simplicity, I'm going to skip the validations in this part
        // of the code.
        return new self(
            ages: $array['age'],
            currencyCode: $array['currency_id'],
            startDate: Carbon::createFromFormat('Y-m-d', $array['start_date']),
            endDate: Carbon::createFromFormat('Y-m-d', $array['end_date'])
        );
    }
}
