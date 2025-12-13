<?php

namespace App\Http\Requests\Account;

use App\Helpers\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class BankAccountReferenceData extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'account_type_id' => ['numeric', 'required'],
            'account_number' => ['string', 'required'],
            'account_name' => ['string', 'required'],
            'referee' => ['array', 'required'],
            'referee.*.name' => ['required','string'],
            'referee.*.email_address' => ['required', 'string'],
            'referee.*.mobile_number' => ['required', 'string'],
            'referee.*.phone_number' => ['nullable', 'string'],
        ];
    }
}
