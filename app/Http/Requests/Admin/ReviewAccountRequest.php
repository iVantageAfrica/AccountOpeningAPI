<?php

namespace App\Http\Requests\Admin;

use App\Helpers\BaseRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

class ReviewAccountRequest extends BaseRequest
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
            'complianceOfficerId' => ['nullable', 'integer', new Exists('admins', 'id')],
        ];
    }
}