<?php

namespace App\Http\Requests\Admin;

use App\Helpers\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateAdminRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firstname' => ['sometimes', 'string', 'max:255'],
            'lastname'  => ['sometimes', 'string', 'max:255'],
            'email'     => ['sometimes', 'email', 'max:255'],
            'role'      => ['sometimes', 'string', Rule::in(['Super Admin', 'Customer Management Officer', 'Compliance Officer'])],
        ];
    }
}
