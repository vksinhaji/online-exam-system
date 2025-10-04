<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnquiryStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required','string','max:255'],
            'mobile_number' => ['required','string','max:20'],
            'service_id' => ['required','exists:services,id'],
            'notes' => ['nullable','string'],
        ];
    }
}
