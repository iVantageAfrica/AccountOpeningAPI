<?php

namespace App\Http\Requests\Account;

use App\Helpers\BaseRequest;
use App\Models\User;
use App\Models\Utility\AccountType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class POSMerchantAccountData extends BaseRequest
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
            'business_sector' => ['required', 'string'],
            'business_name' => ['required', 'string'],
            'phone_number' => ['required','string'],
            'business_address' => ['required','string'],
            'email_address' => ['nullable','string'],
            'city' => ['nullable', 'string'],
            'lga' => ['nullable', 'string'],
            'state' => ['required', 'string'],
            'cac' => ['nullable', 'file', 'mimes:jpg,jpeg,png,doc,docx,pdf', 'max:3048'],
            'valid_id' => ['required', 'file', 'mimes:jpg,jpeg,png,doc,docx,pdf', 'max:3048'],
            'signature' => ['required', 'file', 'mimes:jpg,jpeg,png,doc,docx,pdf', 'max:3048'],
            'utility_bill' => ['required', 'file', 'mimes:jpg,jpeg,png,doc,docx,pdf', 'max:3048'],
            'passport' => ['required', 'file', 'mimes:jpg,jpeg,png,doc,docx,pdf', 'max:3048'],
            'debit_card' => ['required', 'boolean'],
        ];
    }
}
