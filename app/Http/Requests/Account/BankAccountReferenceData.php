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
            'account_type_id' => ['numeric', 'required', 'digits_between:1,7'],
            'account_number' => ['string', 'required', 'max:20'],
            'account_name' => ['string', 'required', 'max:100'],
            'referee' => ['array', 'required'],
            'referee.*.name' => ['required','string', 'max:100'],
            'referee.*.email_address' => ['required', 'email', 'max:150'],
            'referee.*.mobile_number' => ['required', 'string', 'max:30'],
            'referee.*.phone_number' => ['nullable', 'string', 'max:30'],
        ];
    }
}
