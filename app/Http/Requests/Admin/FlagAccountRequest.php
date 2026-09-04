<?php

namespace App\Http\Requests\Admin;

use App\Helpers\BaseRequest;
use Illuminate\Validation\Rule;

class FlagAccountRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'accountNumber' => ['required', 'string'],
            'accountType' => ['required', 'string', Rule::in(['individual', 'corporate'])],
            'reason' => ['required', 'string', 'max:1000'],
        ];
    }
}