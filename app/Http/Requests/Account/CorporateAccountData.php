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
            'bvn' => ['required', 'string', Rule::exists(User::class, 'bvn'), 'max:15'],
            'account_type_id' => ['required', 'numeric', Rule::exists(AccountType::class, 'id')],
            'company_name' => ['required', 'string', 'max:150'],
            'registration_number' => ['required', 'string', 'max:50'],
            'company_type_id' => ['integer', 'required', 'digits_between:1,15'],
            'tin' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:150'],
            'phone_number' => ['nullable','string', 'max:30'],
            'business_email' => ['nullable', 'string', 'max:150'],
            'city' => ['nullable', 'string', 'max:100'],
            'lga' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'debit_card' => ['required', 'boolean'],
            'account_officer' => ['nullable', 'string', 'max:100'],
            'director' => ['array', 'required'],
            'director.*.lastname' => ['required','string', 'max:100'],
            'director.*.firstname' => ['required', 'string', 'max:100'],
            'director.*.bvn' => ['nullable', 'string', 'max:20'],
            'director.*.nin' => ['nullable', 'string', 'max:20'],
            'director.*.email_address' => ['required', 'email', 'max:150'],
            'director.*.phone_number' => ['required', 'string','max:30'],
            'signatory' => ['array', 'required'],
            'signatory.*.name' => ['required', 'string', 'max:100'],
            'signatory.*.email_address' => ['required', 'string', 'max:150'],
            'signatory.*.phone_number' => ['required', 'string', 'max:30'],
            'signatory.*.bvn' => ['required', 'string', 'max:20'],
            'signatory.*.nin' => ['required', 'string', 'max:20'],
         ];
    }
}
