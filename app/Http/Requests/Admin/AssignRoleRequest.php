<?php

namespace App\Http\Requests\Admin;

use App\Helpers\BaseRequest;
use Illuminate\Validation\Rule;

class AssignRoleRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'admin_id' => ['required', 'integer', 'exists:admins,id'],
            'role' => ['required', 'string', Rule::in(['Super Admin', 'Customer Management Officer', 'Compliance Officer'])],
        ];
    }
}
