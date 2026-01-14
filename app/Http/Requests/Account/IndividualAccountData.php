<?php

namespace App\Http\Requests\Account;

use App\Helpers\BaseRequest;
use App\Models\User;
use App\Models\Utility\AccountType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class IndividualAccountData extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (isset($this->debit_card)) {
            $this->merge([
                'debit_card' => filter_var($this->debit_card, FILTER_VALIDATE_BOOLEAN),
            ]);
        }
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'bvn' => ['required', 'string', Rule::exists(User::class, 'bvn')],
            'account_type_id' => ['required', 'numeric', Rule::exists(AccountType::class, 'id')],
            'title' => ['nullable', 'string'],
            'mother_maiden_name' => ['required', 'string'],
            'phone_number' => ['nullable', 'string'],
            'employment_status' => ['required','string'],
            'employer_address' => ['nullable', 'string'],
            'employer' => ['nullable', 'string'],
            'referrer' => ['nullable', 'string'],
            'occupation' => ['nullable', 'string'],
            'marital_status' => ['required','string'],
            'house_number' => ['required','string'],
            'street' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'origin' => ['nullable', 'string'],
            'next_of_kin_name' => ['required', 'string'],
            'next_of_kin_address' => ['required', 'string'],
            'next_of_kin_phone_number' => ['required', 'string'],
            'next_of_kin_relationship' => ['required', 'string'],
//            'referee' => ['array', 'required_if:account_type_id,1'],
//            'referee.*.name' => ['required_if:account_type_id,1','string'],
//            'referee.*.email_address' => ['required_if:account_type_id,1', 'string'],
//            'referee.*.mobile_number' => ['required_if:account_type_id,1', 'string'],
//            'referee.*.phone_number' => ['nullable', 'string'],
            'valid_id' => ['required', 'file', 'mimes:jpg,jpeg,png,doc,docx,pdf', 'max:3048'],
            'signature' => ['required', 'file', 'mimes:jpg,jpeg,png,doc,docx,pdf', 'max:3048'],
            'utility_bill' => ['required', 'file', 'mimes:jpg,jpeg,png,doc,docx,pdf', 'max:3048'],
            'passport' => ['required', 'file', 'mimes:jpg,jpeg,png,doc,docx,pdf', 'max:3048'],
            'debit_card' => ['required', 'boolean'],
        ];
    }
}
