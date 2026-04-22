<?php

namespace App\Http\Requests\Admin;

use App\Enum\AccountNotificationEnum;
use App\Helpers\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class AccountUpdateLinkRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function prepareForValidation(): void
    {
        $this->merge([
           'notification_type' => strtoupper($this->input('notification_type')),
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
            'notification_type' => ['required', 'string',Rule::in(AccountNotificationEnum::values()),],
            'account_type_id' => ['required', 'string', 'max:150'],
            'account_number' => ['required', 'string', 'max:150'],
        ];
    }
}
