<?php

namespace App\Helpers;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();
        $firstErrorMessage = collect($errors)->flatten()->first();
        throw new HttpResponseException(response()->json([
            'statusCode' => false,
            'message' => $firstErrorMessage,
            'errors' => $errors,
        ], 422));
    }
}
