<?php

namespace App\Http\Requests\Account;

use App\Helpers\BaseRequest;
use App\Models\Account\IndividualAccount;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class IndividualAccountUpdateData extends BaseRequest
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
            'account_number' => ['required', 'string', Rule::exists(IndividualAccount::class, 'account_number')],
            'mother_maiden_name' => ['required', 'string', 'max:100'],
            'phone_number' => ['nullable', 'string', 'max:30'],
            'email_address' => ['nullable', 'string', 'email', 'max:100'],
            'employment_status' => ['required','string','max:30'],
            'employer' => ['nullable', 'string','max:100'],
            'account_officer' => ['nullable', 'string', 'max:100'],
            'marital_status' => ['required','string','max:50'],
            'house_number' => ['required','string','max:20'],
            'street' => ['required', 'string','max:150'],
            'city' => ['required', 'string','max:150'],
            'state' => ['required', 'string', 'max:150'],
            'origin' => ['nullable', 'string', 'max:150'],
            'lga' => ['nullable', 'string', 'max:150'],
            'next_of_kin_name' => ['required', 'string', 'max:150'],
            'next_of_kin_address' => ['required', 'string', 'max:150'],
            'next_of_kin_phone_number' => ['required', 'string', 'max:30'],
            'next_of_kin_relationship' => ['required', 'string','max:30'],
        ];
    }
}
