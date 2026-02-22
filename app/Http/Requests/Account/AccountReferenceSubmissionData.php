<?php

namespace App\Http\Requests\Account;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AccountReferenceSubmissionData extends FormRequest
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
            'user_account_number' => ['string', 'required', 'max:20'],
            'name' => ['string', 'required', 'max:100'],
            'email_address' => ['string', 'required', 'email', 'max:150'],
            'mobile_number' => ['string', 'required', 'max:30'],
            'account_name' => ['string', 'required', 'max:100'],
            'account_type' => ['string', 'required', 'max:50'],
            'account_number' => ['string', 'required', 'max:50'],
            'bank_name' => ['string', 'required', 'max:100'],
            'comment' => ['string', 'nullable', 'max:1000'],
            'known_period' => ['string', 'required', 'max:20'],
            'signature' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg,pdf', 'max:2048'],
        ];
    }
}
