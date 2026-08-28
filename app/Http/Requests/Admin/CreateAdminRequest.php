<?php

namespace App\Http\Requests\Admin;

use App\Helpers\BaseRequest;
use Illuminate\Validation\Rule;

class CreateAdminRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname'  => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', 'unique:admins,email'],
            'password'  => ['nullable', 'string'],
            'role'      => ['nullable', 'string', Rule::in(['Super Admin', 'Customer Management Officer', 'Compliance Officer'])],
        ];
    }
}
