<?php

namespace App\Http\Requests\Account;

use App\Helpers\BaseRequest;
use App\Models\Account\Referee;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class UpdateBankAccountReferenceData extends BaseRequest
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
            'referee_id' => ['integer', 'required', Rule::exists(Referee::class, 'id')],
            'account_name' => ['string', 'required'],
            'account_type' => ['string', 'required'],
            'account_number' => ['string', 'required'],
            'bank_name' => ['string', 'required'],
            'signature' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg,pdf', 'max:2048'],
        ];
    }
}
