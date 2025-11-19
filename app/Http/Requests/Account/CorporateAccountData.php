<?php

namespace App\Http\Requests\Account;

use App\Helpers\BaseRequest;
use App\Models\User;
use App\Models\Utility\AccountType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class CorporateAccountData extends BaseRequest
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
            'company_name' => ['required', 'string'],
            'registration_number' => ['required', 'string'],
            'company_type' => ['required', 'string'],
            'tin' => ['required', 'string'],
            'address' => ['required', 'string'],
            'phone_number' => ['nullable','string'],
            'business_email' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'lga' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'account_officer' => ['nullable', 'string'],
            'referee' => ['array', 'required'],
            'referee.*.name' => ['required','string'],
            'referee.*.email_address' => ['required', 'string'],
            'referee.*.mobile_number' => ['required', 'string'],
            'referee.*.phone_number' => ['nullable', 'string'],
            'director' => ['array', 'required'],
            'director.*.lastname' => ['required','string'],
            'director.*.firstname' => ['required', 'string'],
            'director.*.bvn' => ['required', 'string'],
            'signatory' => ['array', 'required'],
            'signatory.*.name' => ['nullable', 'string'],
            'signatory.*.valid_id' => ['required', 'file', 'mimes:jpg,jpeg,png,doc,docx,pdf', 'max:3048'],
            'signatory.*.signature' => ['required', 'file', 'mimes:jpg,jpeg,png,doc,docx,pdf', 'max:3048'],
            'signatory.*.utility_bill' => ['required', 'file', 'mimes:jpg,jpeg,png,doc,docx,pdf', 'max:3048'],
            'signatory.*.passport' => ['required', 'file', 'mimes:jpg,jpeg,png,doc,docx,pdf', 'max:3048'],
            'cac' => ['nullable', 'file', 'mimes:jpg,jpeg,png,doc,docx,pdf', 'max:3048'],
         ];
    }
}
