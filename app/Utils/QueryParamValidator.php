<?php

namespace App\Utils;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class QueryParamValidator
{
    public static function getRequiredParams(Request $request, array $required, array $defaults = []): array
    {
        $missing = [];
        $values = [];

        foreach ($required as $param) {
            $value = $request->query($param);
            if (is_null($value)) {
                if (array_key_exists($param, $defaults)) {
                    $values[$param] = $defaults[$param];
                } else {
                    $missing[] = $param;
                }
            } else {
                if (is_string($value)) {
                    $lower = strtolower($value);
                    if (in_array($lower, ['true', '1', 'yes', 'on'], true)) {
                        $value = true;
                    } elseif (in_array($lower, ['false', '0', 'no', 'off'], true)) {
                        $value = false;
                    }
                }
                $values[$param] = $value;
            }
        }

        if (!empty($missing)) {
            throw new HttpException(422, 'Missing required parameters: ' . implode(', ', $missing));
        }

        return $values;
    }
}
