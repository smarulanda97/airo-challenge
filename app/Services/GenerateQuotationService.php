<?php

namespace App\Services;

use App\Dtos\GenerateQuotationContext;
use App\Dtos\GenerateQuotationResult;
use App\Enums\StatusResult;
use App\Repositories\QuotationRepository;

class GenerateQuotationService
{
    public function __construct(
        protected QuotationRepository $quotationRepo
    ) {}

    /**
     * Execute
     */
    public function execute(GenerateQuotationContext $context): GenerateQuotationResult
    {
        $total = QuotationCalculatorService::from($context->getAges(), $context->getDaysBetween())->calculate();

        if ($total <= 0) {
            return new GenerateQuotationResult(
                status: StatusResult::Error,
                message: "An error occurred while generating the quotation."
            );
        }

        $quotation = $this->quotationRepo->save([
            'total' => $total,
            'ages' => implode(',', $context->getAges()),
            'currency_id' => $context->getCurrencyCode(),
            'start_date' => $context->getStartDate(),
            'end_date' => $context->getEndDate(),
        ]);

        return new GenerateQuotationResult(
            status: StatusResult::Ok,
            quotation: $quotation
        );
    }
}
