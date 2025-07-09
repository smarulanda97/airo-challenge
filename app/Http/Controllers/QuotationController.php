<?php

namespace App\Http\Controllers;

use App\Dtos\GenerateQuotationContext;
use App\Http\Requests\StoreQuotationRequest;
use App\Services\GenerateQuotationService;
use Illuminate\Http\JsonResponse;

class QuotationController extends Controller
{
    public function __construct(
        private GenerateQuotationService $quotationService
    ) {}

    /**
     * Store quotation
     *
     * Receives the request to issue a new quotation. It validates that the information contained
     * in the payload is correct, and if so, stores the data and retrieves the quotation
     * information in the response data. Otherwise, a corresponding error message is returned.
     */
    public function store(StoreQuotationRequest $request): JsonResponse
    {
        $result = $this->quotationService->execute(
            GenerateQuotationContext::fromArray($request->all())
        );

        if ($result->getStatus()->failed()) {
            return response()->json(['message' => 'an error has occurred, please try again later'], 500);
        }

        return response()->json([
            'total' => $result->getQuotation()->total,
            'quotation_id' => $result->getQuotation()->id,
            'currency_id' => $result->getQuotation()->currency_code,
        ]);
    }
}
