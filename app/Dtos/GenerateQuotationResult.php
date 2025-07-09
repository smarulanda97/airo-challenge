<?php

namespace App\Dtos;

use App\Enums\StatusResult;
use App\Models\Quotation;

readonly class GenerateQuotationResult
{
    public function __construct(
        private StatusResult $status,
        private string $message = '',
        private ?Quotation $quotation = null
    ) {}

    /**
     * @return StatusResult
     */
    public function getStatus(): StatusResult
    {
        return $this->status;
    }

    /**
     * @return Quotation|null
     */
    public function getQuotation(): ?Quotation
    {
        return $this->quotation;
    }

    /**
     * @return string
     */
    public function getMessage(): string {
        return $this->message;
    }
}
