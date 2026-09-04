<?php

namespace App\Http\Requests\Admin;

use App\Helpers\BaseRequest;

class ChangePasswordRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string'],
            'password'         => [
                'required',
                'string',
                'min:7',
                'max:100',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/\d/',
                'regex:/[^A-Za-z0-9]/',
                'confirmed',
            ],
        ];
    }
}
