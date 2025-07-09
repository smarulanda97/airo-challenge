<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuotationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Convert the comma separated ages into an array of ages
     */
    protected function prepareForValidation(): void
    {
        if (! $this->has('age')) {
            return;
        }

        $this->merge([
            'age' => empty($this->age) ? [] : explode(',', $this->age),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'age' => ['required', 'array'],
            'age.*' => ['integer', 'min:18', 'max:110'],
            'currency_id' => ['required', 'min:3', 'max:3', Rule::in(['EUR', 'USD', 'GBP'])],
            'start_date' => ['required', Rule::date()->format('Y-m-d')],
            'end_date' => ['required', Rule::date()->todayOrAfter()->format('Y-m-d')],
        ];
    }
}
