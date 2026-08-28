<?php

namespace App\Http\Requests\Admin;

use App\Helpers\BaseRequest;

class UpdateProfileRequest extends BaseRequest
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
        ];
    }
}
