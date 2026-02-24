<?php

namespace App\Http\Requests\Account;

use App\Helpers\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class CompanyDocumentData extends BaseRequest
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
            'account_number' => ['string', 'required', 'max:15'],
            'referee' => ['array', 'required'],
            'referee.*.name' => ['required','string', 'max:100'],
            'referee.*.email_address' => ['required', 'email', 'max:150'],
            'referee.*.mobile_number' => ['required', 'string', 'max:30'],
            'referee.*.phone_number' => ['nullable', 'string','max:30'],
            'cac' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
            'memart' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
            'cac_co2' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
            'cac_co7' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
            'board_resolution' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
            'declaration_form' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
            'partnership_resolution' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
            'proprietor_declaration' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
            'signatory_mandate' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
            'partnership_deed' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
            'tin' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
            'society_resolution' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
            'principal_list' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
            'constitution' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
            'trustee_list' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
            'trust_deed' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
            'trustee_resolution' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
            'nipc_certificate' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
            'business_permit' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
            'due_diligence' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
            'scuml_certificate' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
            'passport' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
        ];
    }
}
