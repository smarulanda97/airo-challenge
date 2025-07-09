<?php

namespace App\Repositories;

use App\Models\Quotation;

class QuotationRepository
{
    /**
     * Save a new quotation
     */
    public function save(array $attributes): Quotation
    {
        $quotation = new Quotation;
        $quotation->fill($attributes);
        $quotation->save();

        return $quotation;
    }
}
