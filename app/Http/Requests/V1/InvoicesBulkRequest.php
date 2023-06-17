<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvoicesBulkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user != null && $user->tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            '*.customerId' => ['required', 'integer'],
            '*.amount' => ['required', 'integer'],
            '*.status' => ['required', Rule::in(['B', 'P', 'V'])],
            '*.billedDate' => ['required', 'date_format:Y-m-d H:i:s'],
            '*.paidDate' => ['date_format:Y-m-d H:i:s', 'nullable'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $data = [];
        foreach ($this->toArray() as $object) {
            $object['customer_id'] = $object['customerId'];
            $object['status'] = strtoupper($object['status']);
            $object['billed_date'] = $object['billedDate'];
            $object['paid_date'] = $object['paidDate'];
            $object['created_at'] = now();
            $object['updated_at'] = now();
            $data[] = $object;
        }
        $this->merge($data);
    }
}
