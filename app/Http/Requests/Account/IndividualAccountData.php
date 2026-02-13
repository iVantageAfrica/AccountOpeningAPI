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
            'bvn' => ['required', 'string', Rule::exists(User::class, 'bvn'), 'max:15'],
            'account_type_id' => ['required', 'numeric', Rule::exists(AccountType::class, 'id')],
            'title' => ['nullable', 'string', 'max:10'],
            'mother_maiden_name' => ['required', 'string', 'max:50'],
            'phone_number' => ['nullable', 'string', 'max:30'],
            'employment_status' => ['required','string','max:30'],
            'employer_address' => ['nullable', 'string','max:100'],
            'employer' => ['nullable', 'string','max:100'],
            'referrer' => ['nullable', 'string','max:50'],
            'occupation' => ['nullable', 'string', 'max:50'],
            'marital_status' => ['required','string','max:20'],
            'house_number' => ['required','string','max:20'],
            'street' => ['required', 'string','max:30'],
            'city' => ['required', 'string','max:50'],
            'state' => ['required', 'string', 'max:100'],
            'origin' => ['nullable', 'string', 'max:100'],
            'lga' => ['nullable', 'string', 'max:100'],
            'next_of_kin_name' => ['required', 'string', 'max:50'],
            'next_of_kin_address' => ['required', 'string', 'max:100'],
            'next_of_kin_phone_number' => ['required', 'string', 'max:30'],
            'next_of_kin_relationship' => ['required', 'string','max:30'],
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
