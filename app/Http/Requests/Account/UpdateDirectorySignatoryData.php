<?php

namespace App\Http\Requests\Account;

use App\Helpers\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class UpdateDirectorySignatoryData extends BaseRequest
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
        $this->merge([
            'type' => strtolower($this->input('type')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', Rule::in('signatory', 'directory')],
            'directorySignatoryId' => ['required', 'string', 'max:10'],
            'valid_id' => ['nullable', 'file', 'mimes:jpg,jpeg,png,doc,docx,pdf', 'max:3048'],
            'signature' => ['nullable', 'file', 'mimes:jpg,jpeg,png,doc,docx,pdf', 'max:3048'],
            'passport' => ['nullable', 'file', 'mimes:jpg,jpeg,png,doc,docx,pdf', 'max:3048'],
            'proof_of_address' => ['nullable', 'file', 'mimes:jpg,jpeg,png,doc,docx,pdf', 'max:3048'],
            'specimen_signature' => ['nullable', 'file', 'mimes:jpg,jpeg,png,doc,docx,pdf', 'max:3048'],
            'partnership_deed' => ['nullable', 'file', 'mimes:jpg,jpeg,png,doc,docx,pdf', 'max:3048'],
            'mode_of_operation' => ['nullable', 'file', 'mimes:jpg,jpeg,png,doc,docx,pdf', 'max:3048'],
            'joint_mandate' => ['nullable', 'file', 'mimes:jpg,jpeg,png,doc,docx,pdf', 'max:3048'],
            'board_approve' => ['nullable', 'file', 'mimes:jpg,jpeg,png,doc,docx,pdf', 'max:3048'],
        ];
    }
}
